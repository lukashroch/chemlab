<?php namespace ChemLab;

class Store extends ExtendedModel
{
    protected $table = 'stores';

    protected $guarded = ['id'];
    protected $fillable = ['parent_id', 'name', 'abbr', 'description', 'temp_min', 'temp_max'];
    protected $nullable = ['parent_id'];

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

    public function scopeSelectList($query, $except = array())
    {
        $stores = $query->select('id', 'parent_id', 'name')
            ->where(function ($query) use ($except) {
                if (!empty($except)) {
                    $query->whereNotIn('id', $except);
                }
            })
            ->orderBy('name', 'asc')->get();

        $aStores = array();
        foreach ($stores as $store) {
            $storeId = $store->id;
            $aStores[$storeId] = $store->name;
            while ($store->parent) {
                $aStores[$storeId] = $store->parent->abbr ? $store->parent->abbr . ' | ' . $aStores[$storeId] : preg_replace('~\b(\w)|.~', '$1', $store->parent->name) . ' | ' . $aStores[$storeId];
                $store = $store->parent;
            }
        }
        asort($aStores);
        return $aStores;
    }

    public function getChildrenIdList()
    {
        $aList = array($this->id);
        $this->fillChildrenIdList($aList, $this->children);
        return $aList;
    }

    public function fillChildrenIdList(&$aList, $children)
    {
        foreach ($children as $child) {
            array_push($aList, $child->id);
            $this->fillChildrenIdList($aList, $child->children);
        }
        return $aList;
    }
}
