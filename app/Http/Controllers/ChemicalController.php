<?php

namespace ChemLab\Http\Controllers;

use ChemLab\Helpers\Parser\Parser;
use ChemLab\Http\Requests\BrandCheckRequest;
use ChemLab\Http\Requests\ChemicalRequest;
use ChemLab\Http\Resources\Chemical\EntryResource;
use ChemLab\Models\Brand;
use ChemLab\Models\Category;
use ChemLab\Models\Chemical;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\View\View;
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

        $this->middleware('permission:chemicals-edit')->only(['checkBrand', 'parse']);
    }

    /**
     * Resource listing
     *
     * @return JsonResource | BinaryFileResponse | View
     */
    public function index(): JsonResource|BinaryFileResponse|View
    {
        $query = Chemical::select(
            'chemicals.id', 'chemicals.name', 'chemicals.iupac', 'chemicals.brand_id',
            'chemicals.catalog_id', 'chemicals.cas', 'chemicals.chemspider', 'chemicals.pubchem',
            'chemicals.mw', 'chemicals.formula', 'chemicals.synonym', 'chemicals.description',
            'chemicals.symbol', 'chemicals.signal_word', 'chemicals.h', 'chemicals.p',
            'chemical_items.id as item_id',
            'chemical_items.store_id',
            'chemical_items.amount',
            'chemical_items.unit',
            'chemical_items.created_at',
            'chemical_items.updated_at',
            'brands.name as brand',
            'category_chemical.category_id',
            'stores.tree_name as store',
            'stores.team_id as team')
            ->leftJoin('brands', 'chemicals.brand_id', '=', 'brands.id')
            ->leftJoin('chemical_items', function ($join) {
                $join->on('chemicals.id', '=', 'chemical_items.chemical_id')->where(function ($query) {
                    $stores = auth()->user()->getManageableStores('chemicals-show');
                    $query->whereIn('chemical_items.store_id', $stores->pluck('id'))
                        ->orWhereNull('chemical_items.store_id');
                });
            })
            ->leftJoin('stores', 'chemical_items.store_id', '=', 'stores.id')
            ->leftJoin('category_chemical', 'chemicals.id', '=', 'category_chemical.chemical_id');

        /* $query = ChemicalItem::select('chemical_items.*', 'chemicals.')
            ->whereIn('chemical_items.store_id', $stores->pluck('id'))
            ->orWhereNull('chemical_items.store_id')
            ->leftJoin('chemical_items', function ($join) {
                $join->on('chemicals.id', '=', 'chemical_items.chemical_id')->where(function ($query) {

                });
            })
            ->join('chemicals', 'chemical_items.chemical_id', '=', 'chemicals.id')
            ->join('stores', 'chemical_items.store_id', '=', 'stores.id');

        if (!array_key_exists('group', $params))
            $query->groupSelect(); */

        $params = request()->only(['item_id', 'category', 'store', 'recent', 'chemspider', 'pubchem', 'formula', 'inchikey']);

        return $this->collection(['name', 'iupac', 'synonym', 'cas', 'catalog_id'], $query, $params);
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
                'category' => Category::select('id', 'name')->orderBy('name')->get(),
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
        $chemical = Chemical::create(array_merge($defaults, $request->except('structure')));
        $chemical->structure()->create($request->input('structure'));
        $chemical->categories()->sync($request->input('categories'));

        return new EntryResource($chemical);
    }

    /**
     * Chemical Resource
     *
     * @param Chemical $chemical
     * @return EntryResource
     */
    private function entry(Chemical $chemical): EntryResource
    {
        $chemical->load(['brand', 'categories', 'structure', 'items' => function ($query) {
            $query->whereIn('store_id', auth()->user()->getManageableStores('chemicals-show')->pluck('id'));
        }, 'items.store', 'items.owner']);

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
        return $this->entry($chemical);
    }

    /**
     * Show the form for editing the specified resource
     *
     * @param Chemical $chemical
     * @return EntryResource
     */
    public function edit(Chemical $chemical): EntryResource
    {
        return $this->entry($chemical);
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
        $chemical->update(array_merge($defaults, $request->except('structure')));
        $chemical->structure()->updateOrCreate(['chemical_id' => $chemical->id], $request->input('structure'));
        $chemical->categories()->sync($request->input('categories'));

        return $this->entry($chemical);
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
        $brands = Brand::where('parse_callback', $callback)->orderBy('id', 'asc')->pluck('url_product', 'id')->toArray();

        $parser = new Parser($request->input('catalog_id'), $callback, $brands);
        $data = array_filter($parser->get());

        return empty($data) ? response()->json([], 404) : response()->json($data);
    }
}
