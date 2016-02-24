<?php namespace ChemLab\Http\Controllers;

use ChemLab\Brand;
use ChemLab\Http\Requests\BrandRequest;
use HtmlEx;
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
        $str = Input::get('search');
        $brands = Brand::orderBy('name', 'asc')
            ->where('name', 'LIKE', "%" . $str . "%")
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
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $brand = Brand::findOrFail($id);

        return view('brand.show')->with(compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $brand = Brand::findOrFail($id);

        return view('brand.form')->with(compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param BrandRequest $request
     * @return Response
     */
    public function update($id, BrandRequest $request)
    {
        $brand = Brand::findOrFail($id);
        $brand->update($request->all());

        return redirect(route('brand.index'))->withFlashMessage(trans('brand.msg.updated', ['name' => $brand->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        return response()->json([
            'state' => 'not_deleted',
            'flash' => HtmlEx::alert(trans('brand.msg.deleted.disabled'), 'danger', true),
        ]);
    }
}
