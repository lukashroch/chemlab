<?php

namespace ChemLab\Http\Controllers;

use ChemLab\Brand;
use ChemLab\Chemical;
use ChemLab\DataTables\ChemicalDataTable;
use ChemLab\Helpers\Parser\Parser;
use ChemLab\Http\Requests\BrandCheckRequest;
use ChemLab\Http\Requests\ChemicalRequest;
use ChemLab\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Prologue\Alerts\Facades\Alert;

class ChemicalController extends ResourceController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('permission:chemical-show')->only('getSDS');
        $this->middleware(['ajax', 'permission:chemical-edit'])->only(['checkBrand', 'parse']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param ChemicalDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(ChemicalDataTable $dataTable)
    {
        $editStores = auth()->user()->getManageableStoreList('chemical-edit');
        return $dataTable->render('chemical.index', compact('editStores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $chemical = new Chemical();
        $brands = Brand::SelectList(true);

        return view('chemical.form', compact('chemical', 'brands'));
    }

    /**
     * Store a newly created Chemical in storage.
     *
     * @param ChemicalRequest $request
     * @return \Illuminate\View\View
     */
    public function store(ChemicalRequest $request)
    {
        $defaults = [
            'symbol' => $request->input('symbol', []),
            'h' => $request->input('h', []),
            'p' => $request->input('p', []),
            'r' => $request->input('r', []),
            's' => $request->input('s', [])
        ];
        $chemical = Chemical::create(array_merge($defaults, $request->except('inchikey', 'inchi', 'smiles', 'sdf')));
        $chemical->structure()->create($request->only('inchikey', 'inchi', 'smiles', 'sdf'));
        if ($file = $request->file('sds')) {
            $ext = $file->guessClientExtension();
            $file->storeAs('sds', "{$chemical->id}.{$ext}");
        }
        Alert::success(trans('chemical.msg.inserted', ['name' => $chemical->name]))->flash();
        return redirect(route('chemical.edit', ['chemical' => $chemical->id]));
    }

    /**
     * Display the specified Chemical.
     *
     * @param Chemical $chemical
     * @return \Illuminate\View\View
     */
    public function show(Chemical $chemical)
    {
        $user = auth()->user();
        $chemical->load(['brand', 'structure', 'items' => function ($query) use ($user) {
            $query->whereIn('store_id', $user->getManageableStores('chemical-show')->pluck('id'));
        }, 'items.store', 'items.owner']);
        $stores = $user->getManageableStoreList('chemical-edit');
        $users = User::SelectList(true);

        return view('chemical.show', compact('chemical', 'stores', 'users'));
    }

    /**
     * Show the form for editing the specified Chemical.
     *
     * @param Chemical $chemical
     * @return \Illuminate\View\View
     */
    public function edit(Chemical $chemical)
    {
        $user = auth()->user();
        $chemical->load(['brand', 'structure', 'items' => function ($query) use ($user) {
            $query->whereIn('store_id', $user->getManageableStores('chemical-show')->pluck('id'));
        }, 'items.store', 'items.owner']);
        $stores = $user->getManageableStoreList('chemical-edit');
        $brands = Brand::SelectList(true);
        $users = User::SelectList(true);

        return view('chemical.form', compact('chemical', 'brands', 'stores', 'users'));
    }

    /**
     * Update the specified Chemical in storage.
     *
     * @param Chemical $chemical
     * @param ChemicalRequest $request
     * @return \Illuminate\View\View
     */
    public function update(Chemical $chemical, ChemicalRequest $request)
    {
        $defaults = [
            'symbol' => $request->input('symbol', null),
            'h' => $request->input('h', null),
            'p' => $request->input('p', null),
            'r' => $request->input('r', null),
            's' => $request->input('s', null)
        ];
        $chemical->update(array_merge($defaults, $request->except('inchikey', 'inchi', 'smiles', 'sdf')));
        $chemical->structure()->updateOrCreate(['chemical_id' => $chemical->id], $request->only('inchikey', 'inchi', 'smiles', 'sdf'));
        if ($file = $request->file('sds')) {
            $ext = $file->guessClientExtension();
            $file->storeAs('sds', "{$chemical->id}.{$ext}");
        }
        Alert::success(trans('chemical.msg.updated', ['name' => $chemical->name]))->flash();
        return redirect(route('chemical.edit', ['chemical' => $chemical->id]));
    }

    /**
     * Remove the specified Chemical from storage.
     *
     * @param  Chemical $chemical
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Chemical $chemical)
    {
        return $this->remove($chemical);
    }

    /**
     * Download SDS File
     *
     * @param  Chemical $chemical
     * @return \Illuminate\Http\Response
     */
    public function getSDS(Chemical $chemical)
    {
        if (Storage::disk('local')->exists("sds/{$chemical->id}.pdf"))
            return response()->download(path("sds/{$chemical->id}.pdf"), $chemical->name . '.pdf');
        else
            return back();
    }

    /**
     * Check brand towards database entries to prevent duplications
     *
     * @param BrandCheckRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkBrand(BrandCheckRequest $request)
    {
        return response()->json($data['msg'] = "valid");
    }

    /**
     * Parse chemical data from Sigma Aldrich
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function parse(Request $request)
    {
        $callback = $request->input('callback');
        $brands = Brand::where('parse_callback', 'LIKE', $callback)->orderBy('id', 'asc')->pluck('url_product', 'id')->toArray();

        $parser = new Parser($request->input('catalog_id'), $callback, $brands);

        return response()->json($parser->get());
    }
}
