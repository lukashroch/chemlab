<?php

namespace ChemLab\Http\Controllers;

use ChemLab\Http\Requests\StoreRequest;
use ChemLab\Http\Resources\Store\EntryResource;
use ChemLab\Jobs\UpdateStoreTreeName;
use ChemLab\Models\Store;
use Exception;
use Illuminate\Http\JsonResponse;


class StoreController extends ResourceController
{
    /**
     *
     * @param Store $store
     */
    public function __construct(Store $store)
    {
        parent::__construct($store);

        $this->middleware('can:store,ChemLab\Models\Store')->only('store');
        $this->middleware('can:show,store')->only('show');
        $this->middleware('can:edit,store')->only('edit');
        $this->middleware('can:update,store')->only('update');
        $this->middleware('can:delete,store')->only('delete');
    }

    /**
     * Resource listing
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(['data' => Store::getTree()]);
    }

    /**
     * Reference resource data
     *
     * @return JsonResponse
     */
    public function refs(): JsonResponse
    {
        return $this->refData();
    }

    /**
     * Show the form for creating a new resource
     *
     * @return EntryResource
     */
    public function create(): EntryResource
    {
        return new EntryResource(new Store());
    }

    /**
     * Store a newly created resource in storage
     *
     * @param StoreRequest $request
     * @return EntryResource
     */
    public function store(StoreRequest $request): EntryResource
    {
        $store = Store::create($request->all());
        $this->dispatch(new UpdateStoreTreeName($store));

        return new EntryResource($store);
    }

    /**
     * Display the specified resource
     *
     * @param Store $store
     * @return EntryResource
     */
    public function show(Store $store): EntryResource
    {
        return new EntryResource($store->load('team', 'parent', 'children'));
    }

    /**
     * Show the form for editing the specified resource
     *
     * @param Store $store
     * @return EntryResource
     */
    public function edit(Store $store): EntryResource
    {
        return new EntryResource($store->load('team', 'parent', 'children'));
    }

    /**
     * Update the specified resource in storage
     *
     * @param Store $store
     * @param StoreRequest $request
     * @return EntryResource | JsonResponse
     */
    public function update(Store $store, StoreRequest $request): EntryResource|JsonResponse
    {
        if ($request->input('parent_id') == $store->id || in_array($request->input('parent_id'), $store->getChildrenIdList())) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'parent_id' => [__('stores.msg.is_child_or_self')]
                ]
            ], 422);
        } else {
            $store->update($request->only($store->getFillable()));
            $this->dispatch(new UpdateStoreTreeName($store));
            return new EntryResource($store->load('team', 'parent', 'children'));
        }
    }

    /**
     * Remove the specified resource from storage
     *
     * @param Store $store
     * @return JsonResponse
     * @throws Exception
     */
    public function delete(Store $store): JsonResponse
    {
        if ($store->items->count() > 0)
            return response()->json([
                'message' => __('stores.msg.has_items', ['name' => $store->name])
            ], 403);

        if ($store->hasChildren()) {
            return response()->json([
                'message' => __('stores.msg.has_items', ['name' => $store->name])
            ], 403);
        }

        return $this->triggerDelete($store);
    }
}
