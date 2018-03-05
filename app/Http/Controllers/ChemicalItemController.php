<?php

namespace ChemLab\Http\Controllers;

use ChemLab\Chemical;
use ChemLab\ChemicalItem;
use ChemLab\Http\Requests\ChemicalItemMoveRequest;
use ChemLab\Http\Requests\ChemicalItemRequest;

class ChemicalItemController extends ResourceController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('ajax');
        $this->middleware('permission:chemical-edit')->only('move');

        $this->middleware('can:store,ChemLab\ChemicalItem')->only('store');
        $this->middleware('can:update,item')->only('update');
        $this->middleware('can:delete,item')->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created ChemicalItem in storage.
     *
     * @param ChemicalItemRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ChemicalItemRequest $request)
    {
        $chemical = Chemical::findOrFail($request->input('chemical_id'));
        $count = $request->input('count');
        $html = "";

        for ($i = 0; $i < $count; $i++) {
            $item = new ChemicalItem($request->only('store_id', 'amount', 'unit', 'owner_id'));
            $chemical->items()->save($item);
            $html .= view('chemical.partials.item')->with(['item' => $item])->render();
        }

        return response()->json(['state' => true, 'str' => $html]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ChemicalItem $item
     * @return \Illuminate\Http\Response
     */
    public function edit(ChemicalItem $item)
    {
        //
    }

    /**
     * Update the specified ChemicalItem from storage.
     *
     * @param ChemicalItem $item
     * @param ChemicalItemRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ChemicalItem $item, ChemicalItemRequest $request)
    {
        $item->update($request->only('store_id', 'amount', 'unit', 'owner_id'));
        $item->load('store');
        return response()->json([
            'state' => true,
            'str' => view('chemical.partials.item', ['item' => $item])->render()]);
    }

    /**
     * Update the specified ChemicalItem from storage.
     *
     * @param ChemicalItemMoveRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function move(ChemicalItemMoveRequest $request)
    {
        $items = ChemicalItem::whereIn('id', $request->input('id'));
        $stores = $items->pluck('store_id')->toArray();
        $stores[] = (int)$request->input('store_id');
        $stores = array_unique($stores, SORT_NUMERIC);

        if (!auth()->user()->canManageStore($stores)) {
            return responseJsonError(['error' => [trans('chemical-item.store.error')]]);
        } else {
            $items->update(['store_id' => $request->input('store_id')]);

            return response()->json([
                'type' => 'dt',
                'alert' => ['type' => 'success', 'text' => trans('chemical-item.msg.moved')]
            ]);
        }
    }

    /**
     * Remove the specified ChemicalItem from storage.
     *
     * @param ChemicalItem $item
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ChemicalItem $item)
    {
        $request = request();
        $ids = $request->input('ids');
        $type = $request->input('response');

        if ($ids && is_array($ids) && !empty($ids)) {
            $items = ChemicalItem::whereIn('id', $ids)->get();
            if (auth()->user()->canManageStore($items->pluck('store_id')->toArray())) {
                foreach ($items as $item) {
                    $chemical = $item->chemical;
                    $item->delete();

                    if (!$chemical->hasItems()) {
                        $chemical->delete();
                    }
                }

                return response()->json([
                    'type' => 'dt',
                    'alert' => ['type' => 'success', 'text' => trans('common.msg.multi.deleted')]
                ]);
            } else {
                return responseJsonError(['error' => [trans('chemical-item.store.error')]]);
            }
        } else if ($item->id && $item instanceof ChemicalItem) {
            if (auth()->user()->canManageStore($item->store_id)) {
                $chemical = $item->chemical;
                $name = $chemical->name;

                $item->delete();

                // TODO: cascade structure on chemical, move hasItem check to model (deleting event?)
                if (!$chemical->hasItems() && $type != 'chemical-item') {
                    $chemical->structure->delete();
                    $chemical->delete();
                }

                return response()->json([
                    'type' => $type,
                    'alert' => ['type' => 'success', 'text' => trans('chemical-item.msg.deleted', ['name' => $name])]
                ]);
            } else {
                return responseJsonError(['error' => [trans('chemical-item.store.error')]]);
            }
        } else
            return responseJsonError(['error' => [trans('common.error')]]);
    }
}
