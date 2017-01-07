<?php namespace ChemLab\Http\Controllers;

use ChemLab\Chemical;
use ChemLab\Helpers\Listing;
use ChemLab\Http\Requests\StoreRequest;
use ChemLab\Jobs\UpdateStoreTreeName;
use ChemLab\Store;
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
        $stores = Store::selectTree();
        $action = Auth::user()->can(['store-edit', 'store-delete']);

        return view('store.index')->with(compact('stores', 'action'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $store = new Store();
        $stores = [null => trans('parent.none')] + Store::selectList();

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
        $store = Store::create($request->all());
        $this->dispatch(new UpdateStoreTreeName($store));
        return redirect(route('store.index'))->withFlashMessage(trans('store.msg.inserted', ['name' => $store->name]));
    }

    /**
     * Display the specified resource.
     *
     * @param  Store $store
     * @return Response
     */
    public function show(Store $store)
    {
        $chemicals = new Listing(Chemical::listSelect()->listJoin()->ofStore($store->getChildrenIdList())
            ->groupBy('chemicals.id')->orderBy('chemicals.name', 'asc')->get(),
            route('store.show', ['id' => $store->id]));
        $action = Auth::user()->can(['chemical-edit', 'chemical-delete']);

        return view('store.show')->with(compact('store', 'chemicals', 'action'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Store $store
     * @return Response
     */
    public function edit(Store $store)
    {
        $stores = [null => trans('store.parent.none')] + Store::selectList($store->getChildrenIdList());

        return view('store.form')->with(compact('store', 'stores'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Store $store
     * @param StoreRequest $request
     * @return Response
     */
    public function update(Store $store, StoreRequest $request)
    {
        if ($request->input('parent_id') == $store->id || in_array($request->input('parent_id'), $store->getChildrenIdList())) {
            return redirect(route('store.edit', ['id' => $store->id]))->withInput()->withErrors(trans('store.msg.child_or_self'));
        } else {
            $store->update($request->all());
            $this->dispatch(new UpdateStoreTreeName($store));
            return redirect(route('store.index'))->withFlashMessage(trans('store.msg.updated', ['name' => $store->name]));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Store $store
     * @return Response
     */
    public function destroy(Store $store)
    {
        if ($store->items->count() > 0)
            return response()->json([
                'state' => false,
                'alert' => ['type' => 'warning', 'str' => trans('store.msg.has_items', ['name' => $store->name])]
            ]);
        else if ($store->hasChildren()) {
            return response()->json([
                'state' => false,
                'alert' => ['type' => 'warning', 'str' => trans('store.msg.has_children', ['name' => $store->name])]
            ]);
        } else {
            Session::flash('flash_message', trans('store.msg.deleted', ['name' => $store->name]));
            $store->delete();
            return response()->json(['state' => true, 'url' => route('store.index')]);
        }
    }
}
