<?php namespace ChemLab;

class Store extends ExtendedModel
{
    protected $table = 'stores';

    protected $guarded = ['id'];
    protected $fillable = ['parent_id', 'name', 'abbr_name', 'tree_name', 'description', 'temp_min', 'temp_max'];
    protected $nullable = ['parent_id'];

    public static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            $model->updateTreeName();
        });
    }

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

    public function getTreeName($child = null)
    {
        $store = $child == null ? $this : $child;
        $name = $store->name;
        $store = $store->parent;
        while ($store) {
            if ($store->abbr_name)
                $name = $store->abbr_name . ' ' . $name;
            else if (str_word_count($store->name) > 1)
                $name = preg_replace('~\b(\w)|.~', '$1', $store->name) . ' ' . $name;
            else
                $name = $store->name . ' ' . $name;

            $store = $store->parent;
        }
        return $name;
    }

    public function updateTreeName()
    {
        $this->tree_name = $this->getTreeName();
    }

    public function scopeSelectList($query, $except = array())
    {
        return $query->where(function ($query) use ($except) {
            if (!empty($except)) {
                $query->whereNotIn('id', $except);
            }
        })->orderBy('tree_name', 'asc')->lists('tree_name', 'id')->toArray();
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
