<?php

namespace ChemLab;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Arr;

class User extends Authenticatable implements Auditable
{
    use AuditableTrait, FlushableTrait, LaratrustUserTrait, Notifiable, ScopeTrait;

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
     * The cache keys, that are flushable
     *
     * @var array
     */
    protected static $cacheKeys = ['search', 'list', 'listWithNull', 'manageable_stores'];

    /**
     * Get the user settings.
     *
     * @return Settings
     */
    public function settings()
    {
        return new Settings($this->settings ?: [], $this);
    }

    /**
     * Get the user nmr.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function nmrs()
    {
        return $this->hasMany(Nmr::class, 'user_id');
    }

    /**
     * Get Collection of user's manageable stores
     *
     * @param string $permission
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getManageableStores($permission)
    {
        $key = $this->id . '_manageable_stores' . $permission;
        return localCache('user', $key)->rememberForever($key, function () use ($permission) {
            $stores = Store::doesntHave('children')->orderBy('tree_name', 'asc')->get();
            $stores = $stores->filter(function ($value, $key) use ($permission) {
                return $this->can($permission, $value->team_id);
            });
            return $stores;
        });
    }

    /**
     * Check if user can manage store
     *
     * @param mixed $store
     * @param string permission
     * @param bool $strict
     * @return bool
     */
    public function canManageStore($store, $permission, $strict = true): bool
    {
        if (!is_array($store))
            $store = array($store);

        $stores = $this->getManageableStores($permission)->pluck('id')->toArray();

        return $strict ? !array_diff($store, $stores) : (bool)array_intersect($store, $stores);
    }

    /**
     * Get list of manageable stores
     *
     * @param string $permission
     * @return array
     */
    public function getManageableStoreList($permission): array
    {
        return $this->getManageableStores($permission)->pluck('tree_name', 'id')->toArray();
    }

    /**
     * Scope query if user has selected roles
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  mixed $roles
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHasRoles($query, $roles)
    {
        if ($roles == null || empty($roles))
            return $query;

        return $query->where(function ($query) use ($roles) {
            $query->whereHas('roles', function ($roleQuery) use ($roles) {
                $roleQuery->whereIn('id', is_array($roles) ? $roles : [$roles]);
            });
            if (in_array(0, $roles)) {
                $query->orWhereDoesntHave('roles');
            }
        });
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
}
