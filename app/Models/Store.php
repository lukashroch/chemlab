<?php

namespace ChemLab\Models;

use ChemLab\Models\Interfaces\Flushable;
use ChemLab\Models\Traits\FlushableTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

class Store extends ResourceModel implements Flushable
{
    use FlushableTrait;

    /**
     * The cache keys, that are flushable
     *
     * @var array
     */
    protected static $cacheKeys = ['search', 'treeview'];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'stores';
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
    protected $fillable = ['parent_id', 'team_id', 'name', 'abbr_name', 'tree_name', 'description', 'temp_min', 'temp_max'];

    /**
     * Get array list of stores IDs and tree names
     * @param int|array $team
     * @param array|Collection $except
     * @param bool $noParents
     * @return Collection
     */
    public static function selectList($team, $except = [], $noParents = false): Collection
    {
        return static::select('id', 'tree_name as name')->where(function ($wQuery) use ($team) {
            return $wQuery->whereNull('team_id')->orWhereIn('team_id', $team);
        })->where(function ($wQuery) use ($except, $noParents) {
            if (!empty($except)) {
                $wQuery->whereNotIn('id', $except);
            }

            if ($noParents)
                $wQuery->doesntHave('children');

        })->orderBy('tree_name', 'asc')->get();
    }

    /**
     * Build store list tree hierarchy
     *
     * @return array
     */
    public static function getTree(): array
    {
        $user = auth()->user();
        $stores = static::select('id', 'parent_id', 'team_id', 'name')->orderBy('name', 'asc')->get();
        $stores = $stores->filter(function ($value, $key) use ($user) {
            $value->edit = $user->can('stores-edit', $value->team_id);
            $value->delete = $user->can('stores-delete', $value->team_id);
            return $user->can('stores-show', $value->team_id);
        })->toArray();

        /*$stores = array_map(function ($store) use ($user) {
            unset($store['team_id']);
            return $store;
        }, $stores);*/
        $stores = static::fillSelectTree($stores, null);
        return $stores;
    }

    /**
     * Recursive function for scopeSelectTree()
     *
     * @param array $tree
     * @param mixed $root
     * @return array|null
     */
    private static function fillSelectTree($tree, $root = null)
    {
        $return = [];
        foreach ($tree as $key => $node) {
            if ($node['parent_id'] == $root) {
                unset($tree[$key]);
                $return[] = $node + ['nodes' => static::fillSelectTree($tree, $node['id'])];
            }
        }
        return $return;
    }

    /**
     * Get data for search auto-completion
     *
     * @return array
     */
    public static function autocomplete(): array
    {
        $key = 'search';
        return localCache(static::cachePrefix(), $key)->remember($key, Config::get('cache.ttl', 3600), function () {
            return static::select('name')->orderBy('name')->pluck('name')->toArray();
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
                'title' => __('common.name')
            ],
            [
                'data' => 'abbr_name',
                'title' => __('stores.abbr_name')
            ],
            [
                'data' => 'tree_name',
                'title' => __('stores.tree_name')
            ],
            [
                'data' => 'description',
                'title' => __('common.description')
            ],
            [
                'data' => 'temp_min',
                'title' => __('stores.temp_min')
            ],
            [
                'data' => 'temp_max',
                'title' => __('stores.abbr_name')
            ]
        ]);
    }

    /**
     * Returns parent Store Model
     *
     * @return BelongsTo
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Returns parent Store Model
     *
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Return children Store Models
     *
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(Store::class, 'parent_id', 'id');
    }

    /**
     * Return Chemical Items stored in Store
     *
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(ChemicalItem::class);
    }

    /**
     * Check, whether the are any children stores
     *
     * @return bool
     */
    public function hasChildren(): bool
    {
        return !$this->children->isEmpty();
    }

    /**
     * Build store's tree name based on its parents
     *
     * @param Store $child
     * @return void
     */
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
     * Get list of children Ids, including parent store
     *
     * @return array
     */
    public function getChildrenIdList(): array
    {
        $array = [$this->id];
        $this->fillChildrenIdList($array, $this->children);
        return $array;
    }

    /**
     * Recursive function for getChildrenIdList()
     *
     * @param array $array
     * @param $children
     * @return array
     */
    public function fillChildrenIdList(&$array, $children): array
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
