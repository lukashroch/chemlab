<?php

namespace ChemLab\Http\Controllers;

use ChemLab\Http\Requests\StoreRequest;
use ChemLab\Jobs\UpdateStoreTreeName;
use ChemLab\Store;
use ChemLab\Team;
use Prologue\Alerts\Facades\Alert;

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
        $this->middleware('can:show,store')->only('show');
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
        $stores = Store::getTree();
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
        $teams = auth()->user()->roles()->whereHas('permissions', function ($query) {
            $query->where('name', 'store-create');
        })->pluck('team_id');

        $stores = [null => trans('store.parent.none')] + Store::selectList($teams);
        $teams = [null => trans('store.team.none')] + Team::whereIn('id', $teams)->pluck('display_name', 'id')->toArray();

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

        Alert::success(trans('store.msg.inserted', ['name' => $store->name]))->flash();
        return redirect(route('store.index'));
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
        $teams = auth()->user()->roles()->whereHas('permissions', function ($query) {
            $query->where('name', 'store-edit');
        })->pluck('team_id');

        $stores = [null => trans('store.parent.none')] + Store::selectList($teams, $store->getChildrenIdList());
        $teams = [null => trans('store.team.none')] + Team::whereIn('id', $teams)->pluck('display_name', 'id')->toArray();

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
            Alert::success(trans('store.msg.updated', ['name' => $store->name]))->flash();
            return redirect(route('store.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Store $store
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Store $store)
    {
        if ($store->items->count() > 0)
            $response = [
                'type' => 'error',
                'message' => ['type' => 'notice', 'text' => trans('store.msg.has_items', ['name' => $store->name])]
            ];
        else if ($store->hasChildren()) {
            $response = [
                'type' => 'error',
                'message' => ['type' => 'notice', 'text' => trans('store.msg.has_children', ['name' => $store->name])]
            ];
        } else {
            $response = [
                'type' => 'redirect',
                'url' => route('store.index')
            ];

            Alert::success(trans('store.msg.deleted', ['name' => $store->name]))->flash();
            $store->delete();
        }

        return response()->json($response);
    }
}
