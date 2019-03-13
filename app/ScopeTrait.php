<?php

namespace ChemLab;

trait ScopeTrait
{
    /**
     * scope search method
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string|null $value
     * @param  array $columns
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfString($query, $value, array $columns = [])
    {
        if ($value == null)
            return $query;

        $columns = $columns ?: [$this->table . '.name'];

        return $query->where(function ($query) use ($value, $columns) {
            foreach ($columns as $aKey => $aValue) {
                $where = $aKey ? 'orWhere' : 'where';
                $query->$where($aValue, 'LIKE', "%{$value}%");
            }
        });
    }

    /**
     * Scope query of selected column
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string $column
     * @param  int|string|array $value
     * @param  bool $null
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfColumn($query, $column, $value, $null = false)
    {
        if (!$column || !$value)
            return $query;


        $where = is_array($value) ? 'whereIn' : 'where';

        $query->$where($column, $value);
        if ($null)
            $query->orWhereNull($column);
        return $query;
    }

    /**
     * Scope query of trashed entries
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  mixed $permissions
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfTrashed($query, $permissions)
    {
        return auth()->user()->can($permissions) && method_exists($this, 'trashed') ? $query->withTrashed() : $query;
    }

    /**
     * Get List of resources
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param  bool|string $null
     * @param  string|null $column
     * @return array
     */
    public static function scopeSelectList($query, $null = false, $column = 'name')
    {
        $list = $query->orderBy($column, 'asc')->pluck($column, 'id')->toArray();

        if ($null != false)
            $list = [null => is_string($null) ? $null : trans('common.not.specified')] + $list;

        return $list;

        /*$key = $addNull ? 'listWithNull' : 'list';
        return localCache(static::cachePrefix(), $key)->remember($key, Config::get('cache.ttl', 3600), function () use($null, $column) {
            $list = static::orderBy($column, 'asc')->pluck($column, 'id')->toArray();

            if ($null != false)
                $list = [null => is_string($null) ? $null : trans('common.not.specified')] + $list;

            return $list;
        });*/
    }
}
