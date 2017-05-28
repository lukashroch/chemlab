<?php

namespace ChemLab;

use Yajra\Auditable\AuditableTrait;
use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    use AuditableTrait, FlushableTrait;

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
    protected $fillable = ['name', 'display_name', 'description'];

    /**
     * The cache keys, that are flushable
     *
     * @var array
     */
    protected static $cacheKeys = ['search'];

    /**
     * The formatted name with description
     *
     * @return string
     */
    public function getDisplayNameWithDesc()
    {
        return $this->description ? $this->display_name . ' (' . $this->description . ')' : $this->display_name;
    }

    /**
     * Get data for search auto-completion
     *
     * @return array
     */
    public static function autocomplete()
    {
        return cache()->rememberForever('permission-search', function () {
            return static::select('display_name')->orderBy('display_name')->pluck('display_name')->toArray();
        });
    }
}
