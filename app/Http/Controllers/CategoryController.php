<?php

namespace ChemLab\Http\Controllers;

use ChemLab\Http\Requests\CategoryRequest;
use ChemLab\Http\Resources\Brand\EntryResource;
use ChemLab\Models\Category;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


class CategoryController extends ResourceController
{
    /**
     *
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        parent::__construct($category);
    }

    /**
     * Resource listing
     *
     * @return JsonResource | BinaryFileResponse | View
     */
    public function index(): BinaryFileResponse|JsonResource|View
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
        return $this->refData();
    }

    /**
     * Show the form for creating a new resource
     *
     * @return EntryResource
     */
    public function create(): EntryResource
    {
        return new EntryResource(new Category());
    }

    /**
     * Store a newly created resource in storage
     *
     * @param CategoryRequest $request
     * @return EntryResource
     */
    public function store(CategoryRequest $request): EntryResource
    {
        $category = Category::create($request->all());

        return new EntryResource($category);
    }

    /**
     * Display the specified resource
     *
     * @param Category $category
     * @return EntryResource
     */
    public function show(Category $category): EntryResource
    {
        return new EntryResource($category);
    }

    /**
     * Show the form for editing the specified resource
     *
     * @param Category $category
     * @return EntryResource
     */
    public function edit(Category $category): EntryResource
    {
        return new EntryResource($category);
    }

    /**
     * Update the specified resource in storage
     *
     * @param Category $category
     * @param CategoryRequest $request
     * @return EntryResource
     */
    public function update(Category $category, CategoryRequest $request): EntryResource
    {
        $category->update($request->only($category->getFillable()));
        return new EntryResource($category);
    }

    /**
     * Remove the specified resource from storage
     *
     * @param Category|null $category
     * @return JsonResponse
     * @throws Exception
     */
    public function delete(Category $category = null): JsonResponse
    {
        return $this->triggerDelete($category);
    }
}
