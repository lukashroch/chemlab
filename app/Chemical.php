<?php namespace ChemLab;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;

class Chemical extends ExtendedModel
{
    protected $table = 'chemicals';

    protected $guarded = ['id'];
    protected $fillable = ['name', 'iupac_name', 'brand_id', 'brand_no', 'cas', 'chemspider', 'pubchem', 'mw', 'formula', 'synonym', 'description'];
    protected $nullable = ['brand_id'];

    public function brand()
    {
        return $this->belongsTo('ChemLab\Brand');
    }

    public function structure()
    {
        return $this->hasOne('ChemLab\ChemicalStructure');
    }

    public function items()
    {
        return $this->hasMany('ChemLab\ChemicalItem');
    }

    public function scopeListSelect($query)
    {
        return $query->select('chemicals.id', 'chemicals.name', 'chemicals.brand_id', 'chemicals.brand_no', 'chemicals.synonym', 'chemicals.description',
            DB::raw('SUM(chemical_items.amount) AS amount'),
            DB::raw('GROUP_CONCAT(DISTINCT chemical_items.unit SEPARATOR ",") AS unit'),
            DB::raw('GROUP_CONCAT(DISTINCT CONCAT_WS(" - ", departments.prefix, stores.name) SEPARATOR ", ") AS stores'));
    }

    public function scopeListJoin($query)
    {
        return $query->leftJoin('chemical_items', 'chemicals.id', '=', 'chemical_items.chemical_id')
            ->leftJoin('stores', 'chemical_items.store_id', '=', 'stores.id')
            ->leftJoin('departments', 'stores.department_id', '=', 'departments.id');
    }

    public function scopeStructureJoin($query)
    {
        return $query->leftJoin('chemical_structures', 'chemicals.id', '=', 'chemical_structures.chemical_id');
    }

    public function scopeSearch($query, $str)
    {
        if ($str != null) {
            return $query->where(function ($query) use ($str) {
                $query->where('chemicals.cas', 'LIKE', "%" . $str . "%")
                    ->orWhere('chemicals.brand_no', 'LIKE', "%" . $str . "%")
                    ->orWhere('chemicals.name', 'LIKE', "%" . $str . "%")
                    ->orWhere('chemicals.iupac_name', 'LIKE', "%" . $str . "%")
                    ->orWhere('chemicals.synonym', 'LIKE', "%" . $str . "%");
            });
        }
    }

    public function scopeOfStore($query, $store)
    {
        if ($store != null)
            return $query->where('chemical_items.store_id', '=', $store);
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
        return $query->where('id', '!=', $data['id'])->where('brand_id', '!=', 0)->where('brand_id', $data['brand_id'])->where('brand_no', $data['brand_no']);
    }

    public function itemList()
    {
        return $this->items()
            ->join('stores', 'chemical_items.store_id', '=', 'stores.id')
            ->join('departments', 'stores.department_id', '=', 'departments.id')
            ->select('departments.prefix', 'stores.name', 'chemical_items.*')
            ->orderBy('departments.prefix')
            ->orderBy('stores.name')
            ->orderBy('chemical_items.amount')
            ->get();
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
