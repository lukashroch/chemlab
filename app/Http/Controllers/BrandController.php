<?php

namespace ChemLab\Http\Controllers;

use ChemLab\Brand;
use ChemLab\DataTables\BrandDataTable;
use ChemLab\Http\Requests\BrandRequest;

class BrandController extends ResourceController
{

    /**
     * Display a listing of the resource.
     *
     * @param BrandDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(BrandDataTable $dataTable)
    {
        return $dataTable->render('brand.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('brand.form', ['brand' => new Brand()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BrandRequest $request
     * @return \Illuminate\View\View
     */
    public function store(BrandRequest $request)
    {
        $brand = Brand::create($request->all());

        return redirect(route('brand.index'))->withFlashMessage(trans('brand.msg.inserted', ['name' => $brand->name]));
    }

    /**
     * * Display the specified resource.
     *
     * @param Brand $brand
     * @return \Illuminate\View\View
     */
    public function show(Brand $brand)
    {
        return view('brand.show', compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Brand $brand
     * @return \Illuminate\View\View
     */
    public function edit(Brand $brand)
    {
        return view('brand.form', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Brand $brand
     * @param BrandRequest $request
     * @return \Illuminate\View\View
     */
    public function update(Brand $brand, BrandRequest $request)
    {
        $brand->update($request->all());
        return redirect(route('brand.index'))->withFlashMessage(trans('brand.msg.updated', ['name' => $brand->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Brand $brand
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Brand $brand)
    {
        return $this->remove($brand);
    }
}
