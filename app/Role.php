<?php namespace ChemLab;

use Yajra\Auditable\AuditableTrait;
use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    use AuditableTrait, FlushModelCache;

    protected $guarded = ['id'];

    protected $fillable = ['name', 'display_name', 'description'];

    public function getDisplayNameWithDesc()
    {
        return $this->description ? $this->display_name . ' (' . $this->description . ')' : $this->display_name;
    }
}
