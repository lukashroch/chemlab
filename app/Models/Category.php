<?php

namespace ChemLab\Models;

use ChemLab\Models\Interfaces\Flushable;
use ChemLab\Models\Traits\FlushableTrait;
use ChemLab\Models\Traits\ScopeTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Config;

class Category extends ResourceModel implements Flushable
{
    use FlushableTrait, ScopeTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'categories';

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
    protected $fillable = ['name', 'description'];

    /**
     * The cache keys, that are flushable
     *
     * @var array
     */
    protected static array $cacheKeys = ['search', 'list', 'listWithNull'];

    /**
     *
     * @return BelongsToMany
     */
    public function chemicals(): BelongsToMany
    {
        return $this->belongsToMany(Chemical::class);
    }

    /**
     * Get data for search auto-completion
     *
     * @return array
     * @throws \Exception
     */
    public static function autocomplete(): array
    {
        $key = 'search';
        return localCache(static::cachePrefix(), $key)->remember($key, Config::get('cache.ttl', 3600), function () {
            return static::select('name')->orderBy('name')->pluck('name')->toArray();
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
                'title' => __('common.title')
            ],
            [
                'data' => 'description',
                'title' => __('common.description')
            ],
        ]);
    }
}
