<?php

namespace ChemLab\Http\Controllers;

use ChemLab\Http\Requests\ChemicalItemMoveRequest;
use ChemLab\Http\Requests\ChemicalItemRequest;
use ChemLab\Http\Resources\ChemicalItem\EntryResource;
use ChemLab\Models\Chemical;
use ChemLab\Models\ChemicalItem;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ChemicalItemController extends Controller
{
    /**
     *
     */
    public function __construct()
    {
        $this->middleware('permission:chemicals-edit')->only('move');
        $this->middleware('can:store,ChemLab\ChemicalItem')->only('store');
        $this->middleware('can:update,item')->only('update');
        $this->middleware('can:delete,item')->only('delete');
    }

    /**
     * Store a newly created ChemicalItem in storage.
     *
     * @param ChemicalItemRequest $request
     * @return JsonResource
     */
    public function store(ChemicalItemRequest $request): JsonResource
    {
        $chemical = Chemical::findOrFail($request->input('chemical_id'));
        $count = $request->input('count');

        $items = collect();
        for ($i = 0; $i < $count; $i++) {
            $item = new ChemicalItem($request->only('store_id', 'amount', 'unit', 'owner_id'));
            $chemical->items()->save($item);
            $items->add($item->load('store', 'owner'));
        }

        return EntryResource::collection($items);
    }

    /**
     * Update the specified ChemicalItem from storage.
     *
     * @param ChemicalItem $item
     * @param ChemicalItemRequest $request
     * @return EntryResource
     */
    public function update(ChemicalItem $item, ChemicalItemRequest $request): EntryResource
    {
        $item->update($request->only('store_id', 'amount', 'unit', 'owner_id'));
        return new EntryResource($item->load('store', 'owner'));
    }

    /**
     * Update the specified ChemicalItem from storage.
     *
     * @param ChemicalItemMoveRequest $request
     * @return JsonResponse
     */
    public function move(ChemicalItemMoveRequest $request): JsonResponse
    {
        $items = ChemicalItem::whereIn('id', $request->input('items'));
        $stores = $items->pluck('store_id')->toArray();
        $stores = array_unique($stores, SORT_NUMERIC);

        if (!auth()->user()->canManageStore($stores, 'chemicals-edit')) {
            return response()->json(['message' => __('chemicals.errors.store')], 403);
        } else {
            $items->update(['store_id' => $request->input('store_id')]);
            return response()->json(['status' => 'success']);
        }
    }

    /**
     * Remove the specified ChemicalItem from storage.
     *
     * @param ChemicalItem $item
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(ChemicalItem $item = null): JsonResponse
    {
        if (!is_null($item)) {
            $items = collect()->add($item);
            $count = 1;
        } else {
            $id = request()->input('id', []);
            if (empty($id))
                throw new NotFoundHttpException("No query results");

            $items = ChemicalItem::whereIn('id', $id)->get();
            $count = count($id);
        }

        if ($items->isEmpty() || $count != $items->count())
            throw new NotFoundHttpException("No query results");

        if (!auth()->user()->canManageStore($items->pluck('store_id')->toArray(), 'chemicals-delete'))
            return response()->json(['message' => __('chemicals.errors.store')], 403);

        foreach ($items as $item) {
            $item->delete();
        }
        return response()->json(null, 204);
    }
}
