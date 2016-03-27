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
            $model->setTreeName();
        });
    }

    /**
     * Returns parent Store Model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo('ChemLab\Store');
    }

    /**
     * Return children Store Models
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany('ChemLab\Store', 'parent_id', 'id');
    }

    /**
     * Return Chemical Items stored in Store
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany('ChemLab\ChemicalItem');
    }

    /**
     * Set store's tree name before saving to DB
     */
    public function setTreeName()
    {
        $this->tree_name = $this->buildTreeName();
    }

    // Build store's tree name based on its parents
    public function buildTreeName($child = null)
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

    /**
     * Get array list of stores IDs and tree names
     * @param $query
     * @param array $except
     * @param bool $removeParents
     * @return array
     */
    public function scopeSelectList($query, $except = array(), $removeParents = false)
    {
        $query->where(function ($query) use ($except) {
            if (!empty($except)) {
                $query->whereNotIn('id', $except);
            }
        })->orderBy('tree_name', 'asc');

        if ($removeParents) {
            $stores = $query->get()->filter(function ($value, $key) {
                return $value->children->isEmpty();
            });

            return $stores->pluck('tree_name', 'id')->sort();

        } else
            return $query->lists('tree_name', 'id')->toArray();
    }

    /**
     * Build store list tree hierarchy
     *
     * @param $query
     * @return array|null
     */
    public function scopeSelectTree($query)
    {
        $stores = $query->select('id', 'parent_id', 'name as text')->orderBy('name', 'asc')->get()->toArray();
        $stores = $this->fillSelectTree($stores, null);
        return $stores;
    }

    /**
     * Recursive function for scopeSelectTree()
     *
     * @param $tree
     * @param null $root
     * @return array|null
     */
    private function fillSelectTree($tree, $root = null)
    {
        $return = array();
        foreach ($tree as $key => $node) {
            if ($node['parent_id'] == $root) {
                unset($tree[$key]);
                $return[] = $node + ['nodes' => $this->fillSelectTree($tree, $node['id'])];
            }
        }
        return empty($return) ? null : $return;
    }

    /**
     * Get list of children Ids, including parent store
     *
     * @return array
     */
    public function getChildrenIdList()
    {
        $array = array($this->id);
        $this->fillChildrenIdList($array, $this->children);
        return $array;
    }

    /**
     *
     * Recursive function for getChildrenIdList()
     *
     * @param $array
     * @param $children
     * @return array
     */
    public function fillChildrenIdList(&$array, $children)
    {
        foreach ($children as $child) {
            array_push($array, $child->id);
            $this->fillChildrenIdList($array, $child->children);
        }
        return $array;
    }
}
