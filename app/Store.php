<?php namespace ChemLab;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Store extends Model
{
    protected $table = 'stores';

    protected $guarded = ['id'];
    protected $fillable = ['parent_id', 'name', 'abbr', 'description', 'temp_min', 'temp_max'];

    public function parent()
    {
        return $this->belongsTo('ChemLab\Store');
    }

    public function children()
    {
        return $this->hasMany('ChemLab\Store', 'parent_id', 'id');
    }

    public function items()
    {
        return $this->hasMany('ChemLab\ChemicalItem');
    }

    public function scopeSelectList($query, $id = array())
    {
        //return $query->orderBy('name', 'asc')->lists('name', 'id')->toArray();

        $stores = $query->select('id', 'parent_id', 'name')->whereNotIn('id', $id)->whereNotIn('parent_id', $id)->orderBy('name', 'asc')->get();

        $aStores = array();
        foreach($stores as $store)
        {
            $storeId = $store->id;
            $aStores[$storeId] = $store->name;
            while ($store->parent)
            {
                $aStores[$storeId] = $store->parent->abbr ? $store->parent->abbr.' | '.$aStores[$storeId] : preg_replace('~\b(\w)|.~', '$1', $store->parent->name).' | '.$aStores[$storeId];
                $store = $store->parent;
            }
        }
        asort($aStores);
        return $aStores;
    }

    public function scopeOfDepartment($query, $department)
    {
        if ($department == null)
            return $query;

        if (is_array($department))
            return $query->whereIn('department_id', $department);
        else
            return $query->where('department_id', $department);
    }

    public function scopeUniqueStore($query, $data)
    {
        return $query->where('id', '!=', $data['id'])->where('name', $data['name'])->where('department_id', $data['department_id']);
    }
}
