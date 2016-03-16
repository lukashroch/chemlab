<?php namespace ChemLab\Http\Controllers;

use ChemLab\Chemical;
use ChemLab\Helpers\Listing;
use ChemLab\Http\Requests\StoreRequest;
use ChemLab\Store;
use HtmlEx;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

/**
 * Class StoreController
 * @package ChemLab\Http\Controllers
 */
class StoreController extends ResourceController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $stores = Store::select('id', 'parent_id', 'name')->orderBy('name', 'asc')->get()->toArray();
        $stores = $this->parseTree($stores, null);
        $action = Auth::user()->can(['store-edit', 'store-delete']);

        return view('store.index')->with(compact('stores', 'action'));
    }

    private function parseTree($tree, $root = null, $actions = null)
    {
        $return = array();
        foreach ($tree as $key => $node) {
            if ($node['parent_id'] == $root) {
                unset($tree[$key]);
                $return[] = $node + ['text' => $node['name'],
                        'nodes' => $this->parseTree($tree, $node['id'], HtmlEx::icon('store.edit', $node['id'])),
                        'actions' => HtmlEx::icon('store.edit', $node['id'])
                        //.HtmlEx::icon('store.delete', $node['id'], ['name' => $node['name']])
                    ];
            }
        }
        return empty($return) ? null : $return;
    }

    private function toTree($array)
    {
        $flat = array();
        $tree = array();

        foreach ($array as $key => $store) {
            //dd($array);
            if (!isset($flat[$store['id']])) {
                //$flat[$store['id']] = $store + ['children' => array()];
                $flat[$store['id']] = array();
            }
            if (!empty($store['parent_id'])) {
                $flat[$store['parent_id']]['children'][] = $store;
            } else {
                $tree[$store['id']] = $store;
            }
        }

        return $tree;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $store = new Store();
        $stores = [null => trans('parent.none')] + Store::SelectList();

        return view('store.form')->with(compact('store', 'stores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return Response
     */
    public function store(StoreRequest $request)
    {
        if ($this->hasUniqueChildName($request->input()))
            return redirect(route('store.create'))->withInput()->withErrors(trans('store.unique.child'));
        else {
            $store = Store::create($request->all());
            return redirect(route('store.index'))->withFlashMessage(trans('store.msg.inserted', ['name' => $store->name]));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $store = Store::findOrFail($id);
        $chemicals = new Listing(Chemical::listSelect()->listJoin()->OfStore($id)
            ->groupBy('chemicals.id')
            ->orderBy('chemicals.name', 'asc')
            ->get(),
            route('store.show', ['id' => $id]));
        $action = Auth::user()->can(['chemical-edit', 'chemical-delete']);

        return view('store.show')->with(compact('store', 'chemicals', 'action'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $store = Store::findOrFail($id);
        $stores = [null => trans('store.parent.none')] + Store::SelectList($store->getChildrenIdList());

        return view('store.form')->with(compact('store', 'stores'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param StoreRequest $request
     * @return Response
     */
    public function update($id, StoreRequest $request)
    {
        if ($this->hasUniqueChildName($request->input(), $id))
            return redirect(route('store.edit', ['id' => $id]))->withInput()->withErrors(trans('store.msg.name'));
        else {
            $store = Store::findOrFail($id);
            if ($request->input('parent_id') == $store->id || in_array($request->input('parent_id'), $store->getChildrenIdList())) {
                return redirect(route('store.edit', ['id' => $id]))->withInput()->withErrors(trans('store.msg.child_or_self'));
            } else {
                $store->update($request->all());
                return redirect(route('store.index'))->withFlashMessage(trans('store.msg.updated', ['name' => $store->name]));
            }
        }
    }

    private function hasUniqueChildName($input, $except = null)
    {
        return (bool)$store = Store::select('id')->where('name', 'LIKE', $input['name'])
            ->where(function ($query) use ($input, $except) {
                if (empty($input['parent_id']))
                    $query->whereNull('parent_id');
                else
                    $query->where('parent_id', $input['parent_id']);

                if ($except != null)
                    $query->where('id', '!=', $except);
            })->count();
    }

    private function hasChildGroup($input, $except = null)
    {
        return Store::select('id')->where('parent_id', $input['parent_id'])->where('name', $input['name'])->where('id', '!=', $input['id']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $store = Store::findOrFail($id);
        if ($store->items->count() > 0)
            return response()->json([
                'state' => false,
                'alert' => ['type' => 'warning', 'str' => trans('store.msg.has_items', ['name' => $store->name])]
            ]);
        else {
            Session::flash('flash_message', trans('store.msg.deleted', ['name' => $store->name]));
            $store->delete();
            return response()->json(['state' => true, 'url' => route('store.index')]);
        }
    }
}
