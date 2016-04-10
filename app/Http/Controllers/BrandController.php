<?php namespace ChemLab\Http\Controllers;

use ChemLab\Brand;
use ChemLab\Http\Requests\BrandRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class BrandController extends ResourceController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $brands = Brand::orderBy('name', 'asc')
            ->where('name', 'LIKE', "%" . Input::get('search') . "%")
            ->paginate(Auth::user()->listing)
            ->appends(Input::All());

        $action = Auth::user()->can(['brand-edit', 'brand-delete']);

        return view('brand.index')->with(compact('brands', 'action'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('brand.form')->with(['brand' => new Brand()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BrandRequest $request
     * @return Response
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
     * @return Response
     */
    public function show(Brand $brand)
    {
        return view('brand.show')->with(compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Brand $brand
     * @return Response
     */
    public function edit(Brand $brand)
    {
        return view('brand.form')->with(compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Brand $brand
     * @param BrandRequest $request
     * @return Response
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
     * @return Response
     */
    public function destroy(Brand $brand)
    {
        return response()->json([
            'state' => false,
            'alert' => ['type' => 'warning', 'str' => trans('brand.msg.deleted.disabled')]
        ]);
    }
}
