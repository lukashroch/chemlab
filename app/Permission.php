<?php

namespace ChemLab;

use Yajra\Auditable\AuditableTrait;
use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    use AuditableTrait, FlushModelCache;

    protected $guarded = ['id'];

    protected $fillable = ['name', 'display_name', 'description'];

    public function getDisplayNameWithDesc()
    {
        return $this->description ? $this->display_name . ' (' . $this->description . ')' : $this->display_name;
    }

    public static function autocomplete()
    {
        return cache()->tags('permission')->rememberForever('search', function () {
            return static::select('display_name')->orderBy('display_name')->pluck('display_name')->toArray();
        });
    }
}
