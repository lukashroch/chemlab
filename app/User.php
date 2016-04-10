<?php namespace ChemLab;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use EntrustUserTrait, FlushModelCache;

    protected $table = 'users';

    protected $guarded = ['id'];

    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    protected $rules = [
        'name' => 'required|min:5|max:255|unique:users,name',
        'email' => 'required|email|max:255|unique:users,email',
        //'password' => 'required|confirmed|min:6',
    ];

    public function compounds()
    {
        return $this->hasMany('ChemLab\Compound', 'owner_id');
    }

    public function hasCompounds()
    {
        return (bool) $this->compounds()->count();
    }

    public function isOwnCompound($id)
    {
        return in_array($id, $this->compounds()->pluck('id')->toArray());
    }

    public function scopeSelectList($query)
    {
        return $query->orderBy('name', 'asc')->lists('name', 'id')->toArray();
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
}
