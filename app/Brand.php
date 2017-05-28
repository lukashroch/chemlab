<?php

namespace ChemLab;

class Brand extends Model
{
    use FlushableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'brands';

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
    protected $fillable = ['name', 'url_product', 'url_sds', 'parse_callback', 'description'];

    /**
     * The cache keys, that are flushable
     *
     * @var array
     */
    protected static $cacheKeys = ['search', 'list', 'listWithNull'];

    /**
     * Get the brand chemicals.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function chemicals()
    {
        return $this->hasMany(Chemical::class);
    }

    public function scopeSelectList($query)
    {
        return $query->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
    }

    /**
     * Get list of brands
     *
     * @param bool $addNull
     * @return array
     */
    public static function getList($addNull = true)
    {
        return cache()->rememberForever($addNull ? 'brand-listWithNull' : 'brand-list', function () use ($addNull) {
            $list = static::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
            if ($addNull)
                $list = [0 => trans('common.not.specified')] + $list;

            return $list;
        });
    }

    /**
     * Get data for search auto-completion
     *
     * @return array
     */
    public static function autocomplete()
    {
        return cache()->rememberForever('brand-search', function () {
            return static::select('name')->orderBy('name')->pluck('name')->toArray();
        });
    }
}
