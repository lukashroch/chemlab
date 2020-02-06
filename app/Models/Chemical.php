<?php

namespace ChemLab\Models;

use ChemLab\Models\Interfaces\Flushable;
use ChemLab\Models\Traits\FlushableTrait;
use ChemLab\Models\Traits\ScopeTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;

class Chemical extends ResourceModel implements Flushable
{
    use FlushableTrait, ScopeTrait;

    /**
     * The cache keys, that are flushable
     *
     * @var array
     */
    protected static $cacheKeys = ['search'];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'chemicals';
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
    protected $fillable = ['name', 'iupac_name', 'brand_id', 'catalog_id', 'cas', 'chemspider', 'pubchem', 'mw',
        'formula', 'synonym', 'description', 'symbol', 'signal_word', 'h', 'p', 'r', 's'];
    /**
     * The list of attributes to cast.
     *
     * @var array
     */
    protected $casts = [
        'symbol' => 'array',
        'h' => 'array',
        'p' => 'array',
        'r' => 'array',
        's' => 'array'
    ];

    public static function boot()
    {
        parent::boot();
        static::deleted(function ($model) {
            $model->structure()->delete();
            $model->items()->delete();
        });
    }

    /**
     * Get data for search auto-completion
     *
     * @return array
     */
    public static function autocomplete(): array
    {
        $key = 'search';
        return localCache('chemical', $key)->rememberForever($key, function () {
            $chemicals = static::select('name', 'iupac_name', 'synonym', 'catalog_id', 'cas')->get();
            $data = [];

            foreach ($chemicals as $chemical) {
                $data = array_merge($data, [$chemical->catalog_id, $chemical->name],
                    explode(';', $chemical->cas),
                    explode(';', $chemical->iupac_name),
                    explode(';', $chemical->synonym)
                );
            }

            return array_values(array_filter(array_unique($data)));
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
            ]
        ]);
    }

    /**
     * @return BelongsTo
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * @return HasOne
     */
    public function structure(): HasOne
    {
        return $this->hasOne(ChemicalStructure::class);
    }

    /**
     * @return bool
     */
    public function hasItems(): bool
    {
        return (bool)$this->items()->count();
    }

    /**
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(ChemicalItem::class);
    }

    /**
     * @return string
     */
    public function getDisplayNameWithDesc()
    {
        return $this->description ? $this->name . ' (' . $this->description . ')' : $this->name;
    }

    /**
     * @param $value
     * @return array
     */
    public function getSymbolAttribute($value)
    {
        return (!empty($value)) ? json_decode($value) : [];
    }

    /**
     * @param $value
     * @return array
     */
    public function getHAttribute($value)
    {
        return (!empty($value)) ? json_decode($value) : [];
    }

    /**
     * @param $value
     * @return array
     */
    public function getPAttribute($value)
    {
        return (!empty($value)) ? json_decode($value) : [];
    }

    /**
     * @param $value
     * @return array
     */
    public function getRAttribute($value)
    {
        return (!empty($value)) ? json_decode($value) : [];
    }

    /**
     * @param $value
     * @return array
     */
    public function getSAttribute($value)
    {
        return (!empty($value)) ? json_decode($value) : [];
    }

    public function scopeGroupSelect($query)
    {
        $engine = config('database.default');
        $prefix = config("database.connections.{$engine}.prefix");

        return $query->select('chemicals.id', 'chemicals.name', 'chemicals.brand_id', 'chemicals.catalog_id',
            'chemicals.cas', 'chemicals.synonym', 'chemicals.description',
            DB::raw("GROUP_CONCAT({$prefix}chemical_items.id SEPARATOR ';') AS item_id"),
            DB::raw("SUM({$prefix}chemical_items.amount) AS amount"),
            DB::raw("GROUP_CONCAT(DISTINCT {$prefix}chemical_items.unit SEPARATOR ',') AS unit"),
            DB::raw("MAX({$prefix}chemical_items.created_at) AS date"),
            DB::raw("GROUP_CONCAT(DISTINCT {$prefix}chemical_items.store_id SEPARATOR ';') AS store_id"),
            DB::raw("GROUP_CONCAT(DISTINCT {$prefix}stores.tree_name SEPARATOR ';') AS store_name"))
            ->groupBy('chemicals.id');
    }

    public function scopeNonGroupSelect($query)
    {
        return $query->select('chemicals.id', 'chemicals.name', 'chemicals.brand_id', 'chemicals.catalog_id',
            'chemicals.cas', 'chemicals.synonym', 'chemicals.description',
            'chemical_items.id AS item_id', 'chemical_items.amount', 'chemical_items.created_at AS date',
            'chemical_items.unit', 'chemical_items.store_id', 'stores.tree_name AS store_name');
    }

    public function scopeListJoin($query)
    {
        return $query->leftJoin('chemical_items', 'chemicals.id', '=', 'chemical_items.chemical_id')
            ->leftJoin('stores', 'chemical_items.store_id', '=', 'stores.id');
    }

    public function scopeStructureJoin($query)
    {
        return $query->leftJoin('chemical_structures', 'chemicals.id', '=', 'chemical_structures.chemical_id');
    }

    public function scopeOfStore($query, $store)
    {
        if ($store == null)
            return $query;

        if (is_array($store))
            return $query->whereIn('chemical_items.store_id', $store);
        else
            return $query->where('chemical_items.store_id', $store);
    }

    public function scopeOfDate($query, $date, $operant)
    {
        if ($operant == null)
            return $query;

        $engine = config('database.default');
        $prefix = config("database.connections.{$engine}.prefix");

        return $query->where(DB::raw("DATE({$prefix}chemical_items.created_at)"), $operant, $date);
    }

    public function scopeRecent($query, $since)
    {
        return $query->where('chemical_items.created_at', '>=', $since);
    }

    public function scopeUniqueBrand($query, $brandId, $catalogId, $expect = null)
    {
        return $query->whereNotNull('brand_id')
            ->where('catalog_id', $catalogId)
            ->where('brand_id', $brandId)
            ->when($expect, function ($query) use ($expect) {
                $query->where('id', '!=', $expect);
            });
    }

    /**
     * Get formatted Brand link
     *
     * @return HtmlString|string
     */
    public function formatBrandLink()
    {
        if (!$this->brand || !$this->brand->url_product)
            return $this->catalog_id;
        else
            return new HtmlString("<a href=\"" . url(str_replace('%', $this->catalog_id, $this->brand->url_product)) . "\" target=\"_blank\" rel=\"noopener\">" . $this->catalog_id . "</a>");
    }
}
