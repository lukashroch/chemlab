<?php namespace ChemLab\Http\Controllers;

use ChemLab\Chemical;
use ChemLab\Department;
use ChemLab\Helpers\Listing;
use ChemLab\Http\Requests\StoreRequest;
use ChemLab\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
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
        $stores = Store::select('stores.*', 'departments.prefix')
            ->join('departments', 'stores.department_id', '=', 'departments.id')
            ->OfDepartment(Input::get('department'))
            ->where('stores.name', 'LIKE', "%" . Input::get('search') . "%")
            ->orderBy('prefix', 'asc')
            ->orderBy('stores.name', 'asc')
            ->paginate(Auth::user()->listing)
            ->appends(Input::All());

        $departments = Department::SelectList();
        $action = Auth::user()->can(['store-edit', 'store-delete']);

        $storeTree = Store::select('stores.*')
            ->orderBy('stores.name', 'asc')->get()->toArray();
        $storeTree = $this->parseTree($storeTree);

        return view('store.index')->with(compact('stores', 'storeTree', 'departments', 'action'));
    }

    private function parseTree($tree, $root = null)
    {
        $return = array();
        # Traverse the tree and search for direct children of the root
        foreach ($tree as $key => $node) {
            # A direct child is found
            if ($node['parent_id'] == $root) {
                # Remove item from tree (we don't need to traverse this again)
                unset($tree[$key]);
                # Append the child into result array and parse its children
                $return[] = $node + ['text' => $node['name'], 'nodes' => $this->parseTree($tree, $node['id'])];
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
        $departments = Department::SelectList();

        return view('store.form')->with(compact('store', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return Response
     */
    public function store(StoreRequest $request)
    {
        if ($this->uniqueStore($request))
            return redirect(route('store.create'))->withInput()->withErrors(trans('store.department.unique'));
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
        $departments = Department::SelectList();
        $stores = [null => trans('parent.none')] + Store::SelectList();

        return view('store.form')->with(compact('store', 'stores', 'departments'));
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
        if ($this->uniqueStore($request, $id))
            return redirect(route('store.edit', ['id' => $id]))->withInput()->withErrors(trans('store.department.unique'));
        else {
            $store = Store::findOrFail($id);
            $store->update($request->all());
            return redirect(route('store.index'))->withFlashMessage(trans('store.msg.updated', ['name' => $store->name]));
        }
    }

    /**
     * @param StoreRequest $request
     * @param string $id
     * @return int
     */
    private function uniqueStore(StoreRequest $request, $id = '')
    {
        $store = Store::UniqueStore(['id' => $id, 'name' => $request->input('name'), 'department_id' => $request->input('department_id')])->first();
        return count($store);
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
