<?php

namespace ChemLab;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Laratrust\Traits\LaratrustUserTrait;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements Auditable
{
    use AuditableTrait, FlushableTrait, LaratrustUserTrait, Notifiable;

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
     * The cache keys, that are flushable
     *
     * @var array
     */
    protected static $cacheKeys = ['search', 'list', 'listWithNull'];

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
     * Get the user teams.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }

    /**
     * Tries to return all the cached teams of the user.
     * If it can't bring the teams from the cache,
     * it brings them back from the DB.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function cachedTeams()
    {
        $cacheKey = 'laratrust_teams_for_user_' . $this->getKey();

        if (!Config::get('laratrust.use_cache')) {
            return $this->teams()->get();
        }

        return Cache::remember($cacheKey, Config::get('cache.ttl', 60), function () {
            return $this->teams()->get()->toArray();
        });
    }

    /**
     * Checks if the user has a team by its name.
     *
     * @param  string $team
     * @return bool
     */
    public function hasTeam($team)
    {
        $teams = $this->teams()->get()->toArray();
        //$this->cachedTeams();
        foreach ($teams as $myTeam) {
            if (str_is($team, $myTeam['name'])) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get the user teams list
     *
     * @param bool $null
     * @return array
     */
    public function teamList($null = false)
    {
        $list = $this->teams()->orderBy('display_name', 'asc')->pluck('display_name', 'id')->toArray();

        if ($null != false)
            $list = [null => is_string($null) ? $null : trans('common.not-selected')] + $list;

        return $list;
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

    public function scopeSelectList($query)
    {
        return $query->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
    }

    /**
     * Get list of users
     *
     * @param bool $addNull
     * @return array
     */
    public static function getList($addNull = true)
    {
        $key = $addNull ? 'listWithNull' : 'list';
        return localCache('user', $key)->rememberForever($key, function () use ($addNull) {
            $list = static::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
            if ($addNull)
                $list = [null => trans('common.not.specified')] + $list;

            return $list;
        });
    }

    /**
     * @param string $name
     * @return bool
     */
    public function canHandleRole($name)
    {
        // only 'admin' can attach 'admin' role
        return $name != 'admin' || $this->hasRole('admin');
    }

    /**
     * @param string $permName
     * @param null $roleName
     * @return bool
     */
    public function canHandlePermission($permName, $roleName = null)
    {
        // don't remove permission for admin
        if ($roleName && $roleName == 'admin')
            return false;

        // only 'admin' and user with permission can attach that permission
        return $this->hasRole('admin') || $this->hasPermission($permName);
    }

    /**
     * Get Collection of user stores
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUserStores()
    {
        // TODO need to cache this !!!!
        $stores = Store::doesntHave('children')->whereHas('team.users', function ($tuQuery) {
            $tuQuery->where('id', $this->id);
        })->orderBy('tree_name', 'asc')->get();

        return $stores;

        $key = 'stores_' . $this->getKey();
        return localCache('user', $key)->remember($key, Config::get('cache.ttl', 60), function () {

        });
    }

    /**
     * Get Collection of user's manageable stores
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getManageableStores()
    {
        // TODO need to cache this !!!!
        $stores = $this->getUserStores();

        return $stores->filter(function ($value, $key) {
            return $this->can('store-edit', $value->team_id);
        });

        $key = 'getManageableStores';
        return localCache('user', $key)->rememberForever($key, function () {

        });
    }

    /**
     * Check if user can manage store
     *
     * @param mixed $store
     * @param bool $strict
     * @return bool
     */
    public function canManageStore($store, $strict = true)
    {
        if (!is_array($store))
            $store = array($store);

        $stores = $this->getManageableStores()->pluck('id')->toArray();

        return $strict ? !array_diff($store, $stores) : (bool)array_intersect($store, $stores);
    }

    /**
     * Check if user can manage item
     *
     * @param ChemicalItem $item
     * @param bool $strict
     * @return bool
     */
    public function canManageItem(ChemicalItem $item, $strict = true)
    {
        return $this->canManageStore($item->store_id, $strict);
    }

    /**
     * Get list of manageable stores
     *
     * @return array
     */
    public function getManageableStoreList()
    {
        return $this->getManageableStores()->pluck('tree_name', 'id')->toArray();
    }

    /**
     * Get data for search auto-completion
     *
     * @return array
     */
    public static function autocomplete()
    {
        $key = 'search';
        return localCache('user', $key)->rememberForever($key, function () {
            return array_flatten(User::select('name', 'email')->get()->toArray());
        });
    }
}
