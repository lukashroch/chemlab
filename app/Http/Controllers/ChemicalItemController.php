<?php

namespace ChemLab\Http\Controllers;

use ChemLab\Chemical;
use ChemLab\ChemicalItem;
use ChemLab\Http\Requests\ChemicalItemRequest;
use ChemLab\Http\Requests\ChemicalItemMoveRequest;
use Illuminate\Support\Facades\DB;

class ChemicalItemController extends ResourceController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('ajax');
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
            $html .= view('chemical.partials.item')->with(['item' => $item, 'action' => true])->render();
        }

        return response()->json(['state' => true, 'str' => $html]);
    }

    /**
     * Display the specified resource.
     *
     * @param ChemicalItem $item
     * @return \Illuminate\Http\Response
     */
    public function show(ChemicalItem $item)
    {
        //
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
        return response()->json([
            'state' => true,
            'str' => view('chemical.partials.item', ['item' => $item, 'action' => true])->render()]);
    }

    /**
     * Update the specified ChemicalItem from storage.
     *
     * @param ChemicalItemMoveRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function move(ChemicalItemMoveRequest $request)
    {
        DB::table('chemical_items')->whereIn('id', $request->input('id'))
            ->update(['store_id' => $request->input('store_id')]);

        return response()->json([
            'type' => 'dt',
            'alert' => ['type' => 'success', 'text' => trans('chemical.item.msg.moved')]
        ]);
    }

    /**
     * Remove the specified ChemicalItem from storage.
     *
     * @param ChemicalItem $item
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ChemicalItem $item)
    {
        return $this->remove($item);
    }
}
