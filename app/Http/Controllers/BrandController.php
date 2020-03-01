<?php

namespace ChemLab\Http\Controllers;

use ChemLab\Helpers\Parser\Parser;
use ChemLab\Http\Requests\BrandRequest;
use ChemLab\Http\Resources\Brand\EntryResource;
use ChemLab\Models\Brand;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


class BrandController extends ResourceController
{
    /**
     *
     * @param Brand $brand
     */
    public function __construct(Brand $brand)
    {
        parent::__construct($brand);
    }

    /**
     * Resource listing
     *
     * @return JsonResource | BinaryFileResponse
     */
    public function index()
    {
        return $this->collection(['name', 'description']);
    }

    /**
     * Reference resource data
     *
     * @return JsonResponse
     */
    public function refs(): JsonResponse
    {
        return $this->refData([
            'callbacks' => Parser::getParseCallbacks()
        ]);
    }

    /**
     * Show the form for creating a new resource
     *
     * @return EntryResource
     */
    public function create(): EntryResource
    {
        return new EntryResource(new Brand());
    }

    /**
     * Store a newly created resource in storage
     *
     * @param BrandRequest $request
     * @return EntryResource
     */
    public function store(BrandRequest $request): EntryResource
    {
        $brand = Brand::create($request->all());

        return new EntryResource($brand);
    }

    /**
     * Display the specified resource
     *
     * @param Brand $brand
     * @return EntryResource
     */
    public function show(Brand $brand): EntryResource
    {
        return new EntryResource($brand);
    }

    /**
     * Show the form for editing the specified resource
     *
     * @param Brand $brand
     * @return EntryResource
     */
    public function edit(Brand $brand): EntryResource
    {
        return new EntryResource($brand);
    }

    /**
     * Update the specified resource in storage
     *
     * @param Brand $brand
     * @param BrandRequest $request
     * @return EntryResource
     */
    public function update(Brand $brand, BrandRequest $request): EntryResource
    {
        $brand->update($request->only($brand->getFillable()));
        return new EntryResource($brand);
    }

    /**
     * Remove the specified resource from storage
     *
     * @param Brand $brand
     * @return JsonResponse
     * @throws Exception
     */
    public function delete(Brand $brand = null): JsonResponse
    {
        return $this->triggerDelete($brand);
    }
}
