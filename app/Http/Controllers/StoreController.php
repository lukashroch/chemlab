<?php

namespace ChemLab\Http\Controllers;

use ChemLab\Http\Requests\StoreRequest;
use ChemLab\Jobs\UpdateStoreTreeName;
use ChemLab\Store;

/**
 * Class StoreController
 * @package ChemLab\Http\Controllers
 */
class StoreController extends ResourceController
{
    /**
     *
     * @void
     */
    public function __construct()
    {
        parent::__construct();

        $this->middleware('can:store,ChemLab\Store')->only('store');
        $this->middleware('can:edit,store')->only('edit');
        $this->middleware('can:update,store')->only('update');
        $this->middleware('can:delete,store')->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $stores = Store::selectTree(true);

        return view('store.index', compact('stores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $store = new Store();
        $stores = [null => trans('store.parent.none')] + Store::selectList();
        $teams = auth()->user()->teamList();

        return view('store.form', compact('store', 'stores', 'teams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return \Illuminate\View\View
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
     * @param Store $store
     * @return \Illuminate\View\View
     */
    public function show(Store $store)
    {
        $store->load('team', 'parent', 'children');
        return view('store.show', compact('store'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Store $store
     * @return \Illuminate\View\View
     */
    public function edit(Store $store)
    {
        $store->load('team', 'parent', 'children');
        $teams = auth()->user()->teamList();
        $stores = [null => trans('store.parent.none')] + Store::selectList($store->getChildrenIdList());

        return view('store.form', compact('store', 'stores', 'teams'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Store $store
     * @param StoreRequest $request
     * @return \Illuminate\View\View
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Store $store)
    {
        if ($store->items->count() > 0)
            $response = [
                'type' => 'error',
                'alert' => ['type' => 'warning', 'text' => trans('store.msg.has_items', ['name' => $store->name])]
            ];
        else if ($store->hasChildren()) {
            $response = [
                'type' => 'error',
                'alert' => ['type' => 'warning', 'text' => trans('store.msg.has_children', ['name' => $store->name])]
            ];
        } else {
            $response = [
                'type' => 'redirect',
                'url' => route('store.index')
            ];

            session()->flash('flash_message', trans('store.msg.deleted', ['name' => $store->name]));
            $store->delete();
        }

        return response()->json($response);
    }
}
