<?php

namespace ChemLab\Models;

use ChemLab\Export\Exportable;
use ChemLab\Export\ExportableTrait;
use ChemLab\Models\Interfaces\Flushable;
use ChemLab\Models\Traits\ActionableTrait;
use ChemLab\Models\Traits\FlushableTrait;
use ChemLab\Models\Traits\ScopeTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Config;
use Laratrust\Models\Team as LaratrustTeam;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Team extends LaratrustTeam implements Auditable, Exportable, Flushable
{
    use ActionableTrait, AuditableTrait, ExportableTrait, FlushableTrait, ScopeTrait;

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
     * Get data for search auto-completion
     *
     * @return array
     */
    public static function autocomplete(): array
    {
        $key = 'search';
        return localCache(static::cachePrefix(), $key)->remember($key, Config::get('cache.ttl', 3600), function () {
            return static::select('display_name')->orderBy('display_name')->pluck('display_name')->toArray();
        });
    }

    /**
     * Get export columns.
     *
     * @return array
     */
    public static function exportColumns(): array
    {
        return static::buildExportColumns([
            [
                'data' => 'name',
                'title' => __('common.title_internal')
            ],
            [
                'data' => 'display_name',
                'title' => __('common.title')
            ],
            [
                'data' => 'description',
                'title' => __('common.description')
            ]
        ]);
    }

    /**
     * Return children Store Models
     *
     * @return HasMany
     */
    public function stores(): HasMany
    {
        return $this->hasMany(Store::class);
    }
}
