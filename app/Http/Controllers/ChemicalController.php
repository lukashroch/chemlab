<?php

namespace ChemLab\Http\Controllers;

use ChemLab\Helpers\Parser\Parser;
use ChemLab\Http\Requests\BrandCheckRequest;
use ChemLab\Http\Requests\ChemicalRequest;
use ChemLab\Http\Resources\Chemical\EntryResource;
use ChemLab\Models\Chemical;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


class ChemicalController extends ResourceController
{
    /**
     *
     * @param Chemical $chemical
     */
    public function __construct(Chemical $chemical)
    {
        parent::__construct($chemical);

        $this->middleware('permission:chemicals-show')->only('getSDS');
        $this->middleware(['ajax', 'permission:chemicals-edit'])->only(['checkBrand', 'parse']);
    }

    /**
     * Resource listing
     *
     * @return JsonResource | BinaryFileResponse
     */
    public function index()
    {
        //$user = auth()->user();
        //$stores = auth()->user()->getManageableStores('chemicals-show');
        //$delStores = $user->getManageableStores('chemicals-delete')->pluck('id')->toArray();

        $query = Chemical::with('brand')->leftJoin('chemical_items', function ($join) {
            $join->on('chemicals.id', '=', 'chemical_items.chemical_id')->where(function ($query) {
                $stores = auth()->user()->getManageableStores('chemicals-show');
                $query->whereIn('chemical_items.store_id', $stores->pluck('id'))
                    ->orWhereNull('chemical_items.store_id');
            });
        })->leftJoin('stores', 'chemical_items.store_id', '=', 'stores.id');

        $params = request()->only(['store', 'group', 'recent', 'chemspider', 'pubchem', 'formula', 'inchikey']);
        //Log::info("params" ,[$params]);

        if (!array_key_exists('group', $params))
            $query->groupSelect();

        return $this->collection(['cas', 'catalog_id', 'name', 'iupac_name', 'synonym'], $query, $params);
        //return $this->collection(['cas', 'catalog_id', 'name', 'iupac_name', 'synonym'], $query);
    }

    /**
     * Reference resource data
     *
     * @return JsonResponse
     */
    public function refs(): JsonResponse
    {
        return $this->refData([
            'filter' => [
                'store' => auth()->user()->getManageableStores('chemicals-show')
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource
     *
     * @return EntryResource
     */
    public function create(): EntryResource
    {
        return new EntryResource(new Chemical());
    }

    /**
     * Store a newly created resource in storage
     *
     * @param ChemicalRequest $request
     * @return EntryResource
     */
    public function store(ChemicalRequest $request): EntryResource
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

        return new EntryResource($chemical);
    }

    /**
     * Display the specified resource
     *
     * @param Chemical $chemical
     * @return EntryResource
     */
    public function show(Chemical $chemical): EntryResource
    {
        $chemical->load(['brand', 'structure', 'items' => function ($query) {
            $query->whereIn('store_id', auth()->user()->getManageableStores('chemicals-show')->pluck('id'));
        }, 'items.store', 'items.owner']);

        return new EntryResource($chemical);
    }

    /**
     * Show the form for editing the specified resource
     *
     * @param Chemical $chemical
     * @return EntryResource
     */
    public function edit(Chemical $chemical): EntryResource
    {
        $chemical->load(['brand', 'structure', 'items' => function ($query) {
            $query->whereIn('store_id', auth()->user()->getManageableStores('chemicals-show')->pluck('id'));
        }, 'items.store', 'items.owner']);

        return new EntryResource($chemical);
    }

    /**
     * Update the specified resource in storage
     *
     * @param Chemical $chemical
     * @param ChemicalRequest $request
     * @return EntryResource
     */
    public function update(Chemical $chemical, ChemicalRequest $request): EntryResource
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

        return new EntryResource($chemical);
    }

    /**
     * Remove the specified resource from storage
     *
     * @param Chemical $chemical
     * @return JsonResponse
     * @throws Exception
     */
    public function delete(Chemical $chemical): JsonResponse
    {
        return $this->triggerDelete($chemical);
    }

    /**
     * Force delete the specified resource from storage
     *
     * @param Chemical $chemical
     * @return JsonResponse
     */
    public function destroy(Chemical $chemical): JsonResponse
    {
        return $this->triggerDestroy($chemical);
    }

    /**
     * Check brand towards database entries to prevent duplications
     *
     * @param BrandCheckRequest $request
     * @return JsonResponse
     */
    public function checkBrand(BrandCheckRequest $request): JsonResponse
    {
        return response()->json(['status' => 'success']);
    }

    /**
     * Parse chemical data from Sigma Aldrich
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function parse(Request $request): JsonResponse
    {
        $callback = $request->input('callback');
        $brands = Brand::where('parse_callback', 'LIKE', $callback)->orderBy('id', 'asc')->pluck('url_product', 'id')->toArray();

        $parser = new Parser($request->input('catalog_id'), $callback, $brands);

        return response()->json($parser->get());
    }
}
