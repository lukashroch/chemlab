<?php namespace ChemLab;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;

class Chemical extends Model
{
    use FlushModelCache;

    protected $table = 'chemicals';

    protected $guarded = ['id'];

    protected $fillable = ['name', 'iupac_name', 'brand_id', 'catalog_id', 'cas', 'chemspider', 'pubchem', 'mw', 'formula', 'synonym', 'description', 'symbol', 'signal_word', 'h', 'p', 'r', 's'];

    protected $casts = [
        'symbol' => 'array',
        'h' => 'array',
        'p' => 'array',
        'r' => 'array',
        's' => 'array'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function structure()
    {
        return $this->hasOne(ChemicalStructure::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(ChemicalItem::class);
    }

    public function hasItems()
    {
        return (bool)$this->items()->count();
    }

    public function getDisplayNameWithDesc()
    {
        return $this->description ? $this->name . ' (' . $this->description . ')' : $this->name;
    }

    public function getSymbolAttribute($value)
    {
        return (!empty($value)) ? json_decode($value) : array();
    }

    public function getHAttribute($value)
    {
        return (!empty($value)) ? json_decode($value) : array();
    }

    public function getPAttribute($value)
    {
        return (!empty($value)) ? json_decode($value) : array();
    }

    public function getRAttribute($value)
    {
        return (!empty($value)) ? json_decode($value) : array();
    }

    public function getSAttribute($value)
    {
        return (!empty($value)) ? json_decode($value) : array();
    }

    public function scopeGroupSelect($query)
    {
        return $query->select('chemicals.id', 'chemicals.name', 'chemicals.brand_id', 'chemicals.catalog_id',
            'chemicals.cas', 'chemicals.synonym', 'chemicals.description',
            DB::raw('GROUP_CONCAT(chemical_items.id SEPARATOR ";") AS item_id'),
            DB::raw('SUM(chemical_items.amount) AS amount'),
            DB::raw('GROUP_CONCAT(DISTINCT chemical_items.unit SEPARATOR ",") AS unit'),
            DB::raw('GROUP_CONCAT(DISTINCT stores.tree_name SEPARATOR ", ") AS store_name'))
            ->groupBy('chemicals.id');
    }

    public function scopeNonGroupSelect($query)
    {
        return $query->select('chemicals.id', 'chemicals.name', 'chemicals.brand_id', 'chemicals.catalog_id',
            'chemicals.cas', 'chemicals.synonym', 'chemicals.description',
            'chemical_items.id AS item_id', 'chemical_items.amount',
            'chemical_items.unit', 'stores.tree_name AS store_name');
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

    public function scopeSearch($query, $str)
    {
        if ($str == null)
            return $query;

        return $query->where(function ($query) use ($str) {
            $query->where('chemicals.cas', 'LIKE', "%" . $str . "%")
                ->orWhere('chemicals.catalog_id', 'LIKE', "%" . $str . "%")
                ->orWhere('chemicals.name', 'LIKE', "%" . $str . "%")
                ->orWhere('chemicals.iupac_name', 'LIKE', "%" . $str . "%")
                ->orWhere('chemicals.synonym', 'LIKE', "%" . $str . "%");
        });
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

        return $query->where(DB::raw('DATE(chemical_items.created_at)'), $operant, $date);
    }

    public function scopeRecent($query, $since)
    {
        return $query->where('chemical_items.created_at', '>=', $since);
    }

    public function scopeUniqueBrand($query, $brandId, $catalogId, $expect)
    {
        return $query->where('brand_id', '!=', 0)->where('id', '!=', $expect)->where('brand_id', $brandId)->where('catalog_id', $catalogId);
    }

    public function formatBrandLink()
    {
        if (!$this->brand || !$this->brand->url_product)
            return $this->catalog_id;
        else
            return new HtmlString("<a href=\"" . url(str_replace('%', $this->catalog_id, $this->brand->url_product)) . "\" target=\"_blank\">" . $this->catalog_id . "</a>");
    }
}
