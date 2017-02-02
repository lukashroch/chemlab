<?php namespace ChemLab;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    use FlushModelCache;

    protected $guarded = ['id'];

    protected $fillable = ['name', 'display_name', 'description'];

    public function getDisplayNameWithDesc()
    {
        return $this->description ? $this->display_name . ' (' . $this->description . ')' : $this->display_name;
    }
}
