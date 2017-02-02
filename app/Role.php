<?php namespace ChemLab;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    use FlushModelCache;

    protected $guarded = ['id'];

    protected $fillable = ['name', 'display_name', 'description'];

    public function getDisplayNameWithDesc()
    {
        return $this->description ? $this->display_name . ' (' . $this->description . ')' : $this->display_name;
    }
}
