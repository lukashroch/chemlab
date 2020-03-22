<?php

namespace ChemLab\Models;

use ChemLab\Export\Exportable;
use ChemLab\Export\ExportableTrait;
use ChemLab\Models\Interfaces\Flushable;
use ChemLab\Models\Traits\ActionableTrait;
use ChemLab\Models\Traits\FlushableTrait;
use ChemLab\Models\Traits\ScopeTrait;
use ChemLab\Notifications\NewPassword as NewPasswordNotification;
use ChemLab\Notifications\ResetPassword as ResetPasswordNotification;
use ChemLab\Notifications\VerifyEmail as VerifyEmailNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Laratrust\Traits\LaratrustUserTrait;
use Laravel\Passport\HasApiTokens;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements Auditable, Exportable, Flushable
{
    use ActionableTrait, AuditableTrait, ExportableTrait, FlushableTrait, HasApiTokens, LaratrustUserTrait, Notifiable, ScopeTrait;

    /**
     * The cache keys, that are flushable
     *
     * @var array
     */
    protected static $cacheKeys = ['search', 'list', 'listWithNull', 'manageable_stores'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'settings'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The list of attributes to cast.
     *
     * @var array
     */
    protected $casts = [
        'settings' => 'json'
    ];

    /**
     * Should the audit be strict?
     *
     * @var bool
     */
    protected $auditStrict = true;

    /**
     * Boot
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::deleted(function (User $user) {
            $user->socials()->delete();
        });
    }

    /**
     * @return HasMany
     */
    public function socials(): HasMany
    {
        return $this->hasMany(Social::class);
    }

    /**
     * Get data for search auto-completion
     *
     * @return array
     */
    public static function autocomplete(): array
    {
        $key = 'search';
        return localCache('user', $key)->rememberForever($key, function () {
            return Arr::flatten(User::select('name', 'email')->get()->toArray());
        });
    }

    /**
     * Get export columns.
     *
     * @return array
     */
    public static function exportColumns(): array
    {
        return static::buildExportColumns([
            [
                'data' => 'name',
                'title' => __('users.name')
            ],
            [
                'data' => 'email',
                'title' => __('users.email')
            ],
            [
                'data' => 'roles',
                'title' => __('users.roles.assigned')
            ]
        ]);
    }

    /**
     * Send email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification());
    }

    /**
     * Send new password setup notification.
     *
     * @param string $token
     * @return void
     */
    public function sendNewPasswordNotification($token)
    {
        $this->notify(new NewPasswordNotification($token));
    }

    /**
     * Send the password reset notification.
     *
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Get the user settings.
     *
     * @param $key string|null
     *
     * @return Settings|string
     */
    public function getSettings(string $key = null)
    {
        $settings = new Settings($this->settings ?? [], $this);
        return $key ? $settings->get($key) : $settings;
    }

    /**
     * Set the user settings.
     *
     * @param $key string
     * @param $value mixed
     *
     * @return User
     */
    public function setSettings(string $key, $value): User
    {
        $settings = new Settings($this->settings ?? [], $this);
        $settings->set($key, $value);

        return $this;
    }

    /**
     * @param string $provider
     * @return HasMany
     */
    public function social(string $provider): HasMany
    {
        return $this->hasMany(Social::class)->where('provider', $provider);
    }

    /**
     * Get mapped Team-Roles
     *
     * @return array
     */
    public function teamRoles(): array
    {
        $teams = Team::orderBy('name')->pluck('name')->prepend('global');

        $myRoles = [];
        $uniqueRoles = $this->roles->pluck('name')->unique()->all();

        foreach ($teams as $team) {
            if (!array_key_exists($team, $myRoles))
                $myRoles[$team] = [];

            foreach ($uniqueRoles as $role) {
                if ($this->hasRole($role, $team == 'global' ? 0 : $team))
                    array_push($myRoles[$team], $role);
            }
        }

        return $myRoles;
    }

    /**
     * Check if user can manage store
     *
     * @param mixed $store
     * @param string permission
     * @param bool $strict
     * @return bool
     */
    public function canManageStore($store, string $permission, $strict = true): bool
    {
        if (!is_array($store))
            $store = array($store);

        $stores = $this->getManageableStores($permission)->pluck('id')->toArray();

        return $strict ? !array_diff($store, $stores) : (bool)array_intersect($store, $stores);
    }

    /**
     * Get Collection of user's manageable stores
     *
     * @param string $permission
     * @return Collection
     */
    public function getManageableStores(string $permission): Collection
    {
        $key = $this->id . '_manageable_stores' . $permission;
        return localCache('user', $key)->rememberForever($key, function () use ($permission) {
            $stores = Store::select('id', 'team_id', 'tree_name as name')->doesntHave('children')->orderBy('tree_name', 'asc')->get();
            return $stores->filter(function ($value, $key) use ($permission) {
                return $this->can($permission, $value->team_id);
            })->values();
        });
    }

    /**
     * Scope query if user has selected roles
     *
     * @param Builder $query
     * @param mixed $roles
     * @return void
     */
    public function scopeHasRoles($query, $roles)
    {
        if ($roles == null || empty($roles))
            return;

        $query->where(function ($query) use ($roles) {
            $query->whereHas('roles', function ($roleQuery) use ($roles) {
                $roleQuery->whereIn('id', is_array($roles) ? $roles : [$roles]);
            });
            if (in_array(0, $roles)) {
                $query->orWhereDoesntHave('roles');
            }
        });
    }

    /**
     * Get collection of all permissions for resource
     *
     * @param string $resource
     * @return Collection
     */
    public function getPermissionsForResource(string $resource): Collection
    {
        // TODO - cache
        return $this->allPermissions()->filter(function ($permission) use ($resource) {
            return Str::startsWith($permission->name, $resource);
        })->pluck('name');
    }
}
