<?php namespace ChemLab;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;

class Chemical extends ExtendedModel
{
    use FlushModelCache;

    protected $table = 'chemicals';

    protected $guarded = ['id'];
    protected $fillable = ['name', 'iupac_name', 'brand_id', 'brand_no', 'cas', 'chemspider', 'pubchem', 'mw', 'formula', 'synonym', 'description'];
    protected $nullable = ['brand_id'];

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

    /**
     * @return mixed|string
     */
    public function getDisplayNameWithDesc()
    {
        return $this->description ? $this->name . ' (' . $this->description . ')' : $this->name;
    }

    public function scopeListSelect($query)
    {
        return $query->select('chemicals.id', 'chemicals.name', 'chemicals.brand_id', 'chemicals.brand_no', 'chemicals.description',
            DB::raw('SUM(chemical_items.amount) AS amount'),
            DB::raw('GROUP_CONCAT(DISTINCT chemical_items.unit SEPARATOR ",") AS unit'),
            DB::raw('GROUP_CONCAT(DISTINCT stores.tree_name SEPARATOR ", ") AS stores'))
            ->with('brand');
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
                ->orWhere('chemicals.brand_no', 'LIKE', "%" . $str . "%")
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
        if ($operant != null)
            return $query->where(DB::raw('DATE(chemical_items.created_at)'), $operant, $date);
    }

    public function scopeRecent($query, $since)
    {
        return $query->where('chemical_items.created_at', '>=', $since);
    }

    public function scopeUniqueBrand($query, $data)
    {
        return $query->where('id', '!=', $data['id'])->whereNotNull('brand_id')->where('brand_id', $data['brand_id'])->where('brand_no', $data['brand_no']);
    }

    public function formatBrandLink()
    {
        if (!$this->brand_id)
            return $this->brand_no;
        else
            return new HtmlString("<a href=\"" . url(str_replace('%', $this->brand_no, $this->brand->pattern)) . "\" target=\"_blank\">" . $this->brand_no . "</a>");
    }

    public function formatChemicalFormula()
    {
        return new HtmlString(preg_replace("/(\d+)/", "<sub>$1</sub>", $this->formula));
    }
}
