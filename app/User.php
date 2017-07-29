<?php

namespace ChemLab;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Yajra\Auditable\AuditableTrait;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use AuditableTrait, EntrustUserTrait, FlushableTrait, Notifiable;

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
     * Get the user nmr.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function nmrs()
    {
        return $this->hasMany(Nmr::class, 'user_id');
    }

    /**
     * Get the user chemicals.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function chemicalItemsOwned()
    {
        return $this->hasMany(ChemicalItem::class, 'owner_id');
    }

    /**
     * Get the user compounds.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function compounds()
    {
        return $this->hasMany(Compound::class, 'owner_id');
    }

    /**
     * Check, whether user has any compounds
     *
     * @return bool
     */
    public function hasCompounds()
    {
        return (bool)$this->compounds()->count();
    }

    /**
     * Check, whether user owns provided compound
     * @param int $id
     * @return bool
     */
    public function isOwnCompound($id)
    {
        return in_array($id, $this->compounds()->pluck('id')->toArray());
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
                $list = [0 => trans('common.not.specified')] + $list;

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
        return $this->hasRole('admin') || $this->can($permName);
    }

    /**
     * Get Collection of user's manageable stores
     *
     * @return \Illuminate\Database\Eloquent\Collection;
     */
    public function getManageableStores()
    {
        $key = 'user-manageablestores';
        return localCache('role', $key)->rememberForever($key, function () {
            $stores = new Collection();
            foreach ($this->roles as $role) {
                $stores = $stores->merge($role->manageableStores()->get());
            }
            return $stores->sortBy('tree_name')->unique('id');
        });
    }

    /**
     * Check if user can manage store
     *
     * @param mixed $store
     * @param bool $strict
     * @return bool
     */
    public function canManageStore($store, $strict = false)
    {
        if (!is_array($store))
            $store = array($store);

        $stores = $this->getManageableStores()->pluck('id')->toArray();

        return $strict ? !array_diff($store, $stores) : (bool) array_intersect($store, $stores);
    }

    /**
     * Check if user can manage item
     *
     * @param mixed $item
     * @param bool $strict
     * @return bool
     */
    public function canManageItem($item, $strict = false)
    {
        if (!is_array($item))
            $item = array($item);

        $stores = $this->getManageableStores()->pluck('id')->toArray();

        return $strict ? !array_diff($item, $stores) : (bool) array_intersect($item, $stores);
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
