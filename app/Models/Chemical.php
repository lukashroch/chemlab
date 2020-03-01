<?php

namespace ChemLab\Models;

use ChemLab\Models\Interfaces\Flushable;
use ChemLab\Models\Traits\FlushableTrait;
use ChemLab\Models\Traits\ScopeTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

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
    protected $fillable = ['name', 'iupac', 'brand_id', 'catalog_id', 'cas', 'chemspider', 'pubchem', 'mw',
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
            $chemicals = static::select('name', 'iupac', 'synonym', 'catalog_id', 'cas')->get();
            $data = [];

            foreach ($chemicals as $chemical) {
                $data = array_merge($data, [$chemical->catalog_id, $chemical->name],
                    explode(';', $chemical->cas),
                    explode(';', $chemical->iupac),
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
                'data' => 'item_id',
                'title' => __('common.id')
            ],
            [
                'data' => 'name',
                'title' => __('common.title')
            ],
            [
                'data' => 'amount',
                'title' => __('chemicals.amount')
            ],
            [
                'data' => 'store',
                'title' => __('stores.title')
            ],
            [
                'data' => 'iupac',
                'title' => __('chemicals.iupac')
            ],
            [
                'data' => 'brand',
                'title' => __('chemicals.brand._')
            ],
            [
                'data' => 'catalog_id',
                'title' => __('chemicals.brand.id')
            ],
            [
                'data' => 'cas',
                'title' => __('chemicals.cas')
            ],
            [
                'data' => 'chemspider',
                'title' => __('chemicals.chemspider._')
            ],
            [
                'data' => 'pubchem',
                'title' => __('chemicals.pubchem._')
            ],
            [
                'data' => 'mw',
                'title' => __('chemicals.mw')
            ],
            [
                'data' => 'formula',
                'title' => __('chemicals.formula')
            ],
            [
                'data' => 'synonym',
                'title' => __('chemicals.synonym')
            ],
            [
                'data' => 'description',
                'title' => __('common.description')
            ],
            [
                'data' => 'symbol',
                'title' => __('msds.symbol')
            ],
            [
                'data' => 'signal_word',
                'title' => __('msds.signal_word')
            ],
            [
                'data' => 'h',
                'title' => __('msds.h_abbr')
            ],
            [
                'data' => 'p',
                'title' => __('msds.p_abbr')
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

    /**
     * @param Builder $query
     * @return void
     */
    public function scopeGroupSelect($query)
    {
        $engine = config('database.default');
        $prefix = config("database.connections.{$engine}.prefix");

        $query->select('chemicals.*',
            DB::raw("GROUP_CONCAT({$prefix}chemical_items.id SEPARATOR ';') AS item_id"),
            DB::raw("SUM({$prefix}chemical_items.amount) AS amount"),
            DB::raw("GROUP_CONCAT(DISTINCT {$prefix}chemical_items.unit SEPARATOR ',') AS unit"),
            DB::raw("MAX({$prefix}chemical_items.created_at) AS date"),
            DB::raw("GROUP_CONCAT(DISTINCT {$prefix}chemical_items.store_id SEPARATOR ';') AS store_id"),
            DB::raw("GROUP_CONCAT(DISTINCT {$prefix}stores.tree_name SEPARATOR ';') AS store_name"))
            ->groupBy('chemicals.id');
    }

    /**
     * @param Builder $query
     * @return void
     */
    public function scopeNonGroupSelect($query)
    {
        $query->select('chemicals.id', 'chemicals.name', 'chemicals.brand_id', 'chemicals.catalog_id',
            'chemicals.cas', 'chemicals.synonym', 'chemicals.description',
            'chemical_items.id AS item_id', 'chemical_items.amount', 'chemical_items.created_at AS date',
            'chemical_items.unit', 'chemical_items.store_id', 'stores.tree_name AS store_name');
    }

    /**
     * @param Builder $query
     * @return void
     */
    public function scopeJoinItemsWithStore($query)
    {
        $query
            ->leftJoin('chemical_items', 'chemicals.id', '=', 'chemical_items.chemical_id')
            ->leftJoin('stores', 'chemical_items.store_id', '=', 'stores.id');
    }

    /**
     * @param Builder $query
     * @return void
     */
    public function scopeJoinStructure($query)
    {
        $query->leftJoin('chemical_structures', 'chemicals.id', '=', 'chemical_structures.chemical_id');
    }

    /**
     * @param Builder $query
     * @param array|string $store
     * @return void
     */
    public function scopeOfStore($query, $store)
    {
        if ($store == null)
            return;

        $store = is_array($store) ? $store : [$store];
        $query->whereIn('chemical_items.store_id', $store);
    }

    /**
     * @param Builder $query
     * @param string $date
     * @param string $operant
     * @return void
     */
    public function scopeOfDate($query, $date, $operant)
    {
        if ($operant == null)
            return;

        $engine = config('database.default');
        $prefix = config("database.connections.{$engine}.prefix");

        $query->where(DB::raw("DATE({$prefix}chemical_items.created_at)"), $operant, $date);
    }

    /**
     * @param Builder $query
     * @param $since
     * @return void
     */
    public function scopeRecent($query, $since)
    {
        $query->where('chemical_items.created_at', '>=', $since);
    }

    /**
     * @param Builder $query
     * @param int $brandId
     * @param string $catalogId
     * @param int $expect
     * @return void
     */
    public function scopeUniqueBrand($query, int $brandId, string $catalogId, int $expect = null)
    {
        $query->whereNotNull('brand_id')
            ->where('catalog_id', $catalogId)
            ->where('brand_id', $brandId)
            ->when($expect, function ($query) use ($expect) {
                $query->where('id', '!=', $expect);
            });
    }
}
