<?php

namespace ChemLab;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Yajra\Auditable\AuditableTrait;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use AuditableTrait, EntrustUserTrait, FlushModelCache, Notifiable;

    protected $table = 'users';

    protected $guarded = ['id'];

    protected $fillable = ['name', 'email', 'password', 'options'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'options' => 'array'
    ];

    public function chemicalItemsOwned()
    {
        return $this->hasMany(ChemicalItem::class, 'owner_id');
    }

    public function compounds()
    {
        return $this->hasMany(Compound::class, 'owner_id');
    }

    public function hasCompounds()
    {
        return (bool)$this->compounds()->count();
    }

    public function isOwnCompound($id)
    {
        return in_array($id, $this->compounds()->pluck('id')->toArray());
    }

    /**
     * Get User options value
     * @param $key
     * @return mixed
     */
    public function getOptions($key)
    {
        return $this->options[$key];
    }

    /**
     * Set User options value
     * @param $key
     * @param $value
     * @return $this
     */
    public function setOptions($key, $value)
    {
        return $this->setAttribute('options', array_merge($this->getAttribute('options'), [$key => $value]));
    }

    public function scopeSelectList($query)
    {
        return $query->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
    }

    public static function getList($addNull = true)
    {
        return Cache::tags('user')->rememberForever($addNull ? 'listWithNull' : 'list', function () use ($addNull) {
            $list = static::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
            if ($addNull)
                $list = [0 => trans('common.not.specified')] + $list;

            return $list;
        });
    }

    /**
     * @param $name
     * @return bool
     */
    public function canHandleRole($name)
    {
        // only 'admin' can attach 'admin' role
        return $name != 'admin' || $this->hasRole('admin');
    }

    /**
     * @param $permName
     * @param null $roleName
     * @return bool
     * @internal param $name
     */
    public function canHandlePermission($permName, $roleName = null)
    {
        // don't remove permission for admin
        if ($roleName && $roleName == 'admin')
            return false;

        // only 'admin' and user with permission can attach that permission
        return $this->hasRole('admin') || $this->can($permName);
    }

    public static function autocomplete()
    {
        return cache()->tags('user')->rememberForever('search', function () {
            return array_flatten(User::select('name', 'email')->get()->toArray());
        });
    }
}
