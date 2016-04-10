<?php namespace ChemLab;

class Store extends ExtendedModel
{
    use FlushModelCache;

    protected $table = 'stores';

    protected $guarded = ['id'];
    protected $fillable = ['parent_id', 'name', 'abbr_name', 'tree_name', 'description', 'temp_min', 'temp_max'];
    protected $nullable = ['parent_id'];

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

    public function hasChildren()
    {
        return !$this->children->isEmpty();
    }

    // Build store's tree name based on its parents
    public function buildTreeName($child)
    {
        //$store = $child == null ? $this : $child;
        $store = $child;
        $treeName = $store->name;
        $parentStore = $store->parent;
        while ($parentStore) {
            if ($parentStore->abbr_name)
                $treeName = $parentStore->abbr_name . ' ' . $treeName;
            else if (str_word_count($parentStore->name) > 1)
                $treeName = preg_replace('~\b(\w)|.~', '$1', $parentStore->name) . ' ' . $treeName;
            else
                $treeName = $parentStore->name . ' ' . $treeName;

            $parentStore = $parentStore->parent;
        }
        $store->tree_name = $treeName;
        $store->save();

    }

    /**
     * Get array list of stores IDs and tree names
     * @param $query
     * @param array $except
     * @param bool $noParents
     * @return array
     */
    public function scopeSelectList($query, $except = array(), $noParents = false)
    {
        return $query->where(function ($query) use ($except, $noParents) {
            if (!empty($except)) {
                $query->whereNotIn('id', $except);
            }

            if ($noParents)
                $query->has('children', '=', 0);

        })->orderBy('tree_name', 'asc')->lists('tree_name', 'id')->toArray();
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

    public function storeCallBack($children, $callback)
    {
        foreach ($children as $child) {
            call_user_func_array($callback, array($child));
            $this->storeCallBack($child->children, $callback);
        }
    }
}
