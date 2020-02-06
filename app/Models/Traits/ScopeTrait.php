<?php

namespace ChemLab\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

trait ScopeTrait
{
    public static function bootScopeTrait()
    {
        $flushCache = function ($model) {
            $model->flushScopeTraitCache();
        };

        // If model is using SoftDeletes
        if (in_array(SoftDeletes::class, class_uses_recursive(static::class))) {
            static::restored($flushCache);
        }

        static::saved($flushCache);
        static::deleted($flushCache);
    }

    /**
     * Get List of resources
     *
     * @param bool|string $null
     * @param string|null $column
     * @return array
     */
    public static function selectList($null = false, $column = 'name'): array
    {
        $list = static::getCollectionList()->pluck($column, 'id')->toArray();

        if ($null != false)
            $list = [null => is_string($null) ? $null : __('common.not.selected')] + $list;

        return $list;
    }

    public static function getCollectionList(string $column = 'name'): Collection
    {
        $class = strtolower(class_basename(static::class));
        return Cache::remember("chemlab_{$class}_collection_list", config('cache.ttl'), function () use ($column) {
            return static::query()->select($column, 'id')->orderBy($column, 'asc')->get();
        });
    }

    /**
     * Flush the model's cache.
     *
     * @return void
     */
    public function flushScopeTraitCache()
    {
        $class = strtolower(class_basename($this));
        Cache::forget("chemlab_{$class}_collection_list");
    }

    /**
     * scope search method
     *
     * @param Builder $query
     * @param string|null $value
     * @param array $columns
     * @return void
     */
    public function scopeOfString($query, $value, array $columns = [])
    {
        if ($value == null)
            return;

        $columns = $columns ?: [$this->table . '.name'];

        $query->where(function ($query) use ($value, $columns) {
            foreach ($columns as $aKey => $aValue) {
                $where = $aKey ? 'orWhere' : 'where';
                $query->$where($aValue, 'LIKE', "%{$value}%");
            }
        });
    }

    /**
     * Scope query of selected column
     *
     * @param Builder $query
     * @param string $column
     * @param int|string|array $value
     * @param bool $null
     * @return void
     */
    public function scopeOfColumn($query, $column, $value, $null = false)
    {
        if (!$column || !$value)
            return;

        $where = is_array($value) ? 'whereIn' : 'where';

        $query->$where($column, $value);
        if ($null)
            $query->orWhereNull($column);
    }


    /**
     * Get List of resources
     *
     * @param Builder $query
     * @param bool|string $null
     * @param string|null $column
     * @return array
     */
    /*public static function scopeSelectList($query, $null = false, $column = 'name')
    {
        $list = $query->orderBy($column, 'asc')->pluck($column, 'id')->toArray();

        if ($null != false)
            $list = [null => is_string($null) ? $null : __('common.not.specified')] + $list;

        return $list;

        $key = $addNull ? 'listWithNull' : 'list';
        return localCache(static::cachePrefix(), $key)->remember($key, Config::get('cache.ttl', 3600), function () use($null, $column) {
            $list = static::orderBy($column, 'asc')->pluck($column, 'id')->toArray();

            if ($null != false)
                $list = [null => is_string($null) ? $null : __('common.not.specified')] + $list;

            return $list;
        });
    }*/
}
