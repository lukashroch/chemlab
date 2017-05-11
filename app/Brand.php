<?php

namespace ChemLab;

class Brand extends Model
{
    use FlushModelCache;

    protected $table = 'brands';

    protected $guarded = ['id'];

    protected $fillable = ['name', 'url_product', 'url_sds', 'parse_callback', 'description'];

    public function chemicals()
    {
        return $this->hasMany(Chemical::class);
    }

    public function scopeSelectList($query)
    {
        return $query->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
    }

    public static function getList($addNull = true)
    {
        return cache()->tags('brand')->rememberForever($addNull ? 'listWithNull' : 'list', function () use ($addNull) {
            $list = static::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
            if ($addNull)
                $list = [0 => trans('common.not.specified')] + $list;

            return $list;
        });
    }

    public static function autocomplete()
    {
        return cache()->tags('brand')->rememberForever('search', function () {
            return static::select('name')->orderBy('name')->pluck('name')->toArray();
        });
    }
}
