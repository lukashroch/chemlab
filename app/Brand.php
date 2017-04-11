<?php namespace ChemLab;

use Illuminate\Support\Facades\Cache;

class Brand extends Model
{
    use FlushModelCache;

    protected $table = 'brands';

    protected $guarded = ['id'];

    protected $fillable = ['name', 'url_product', 'url_sds', 'description'];

    public function chemicals()
    {
        return $this->hasMany(Chemical::class);
    }

    public function scopeSelectList($query)
    {
        return $query->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
    }

    public function scopeSelectPatternList($query)
    {
        return $query->where('name', 'LIKE', "%Sigma Aldrich%")->orderBy('id', 'asc')->pluck('url_product', 'id')->toArray();
    }

    public static function getList($addNull = true)
    {
        return Cache::tags('brand')->rememberForever($addNull ? 'listWithNull' : 'list', function () use ($addNull) {
            $list = static::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
            if ($addNull)
                $list = [0 => trans('common.not.specified')] + $list;

            return $list;
        });
    }
}
