<?php namespace ChemLab\Http\Controllers;

use ChemLab\Department;
use ChemLab\Http\Requests\DepartmentRequest;
use ChemLab\Store;
use HtmlEx;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class DepartmentController extends ResourceController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $str = Input::get('search');
        $departments = Department::orderBy('name', 'asc')
            ->where('name', 'LIKE', "%" . $str . "%")
            ->orWhere('prefix', 'LIKE', "%" . $str . "%")
            ->paginate(Auth::user()->listing)
            ->appends(Input::All());

        $action = Auth::user()->can(['department-edit', 'department-delete']);

        return view('department.index')->with(compact('departments', 'action'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('department.form')->with(['department' => new Department()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DepartmentRequest $request
     * @return Response
     */
    public function store(DepartmentRequest $request)
    {
        $department = Department::create($request->all());

        return redirect(route('department.index'))->withFlashMessage(trans('department.msg.inserted', ['name' => $department->name]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $department = Department::findOrFail($id);
        $stores = Store::select('stores.*', 'departments.prefix')
            ->join('departments', 'stores.department_id', '=', 'departments.id')
            ->OfDepartment($id)
            ->orderBy('stores.name', 'asc')
            ->paginate(Auth::user()->listing);
        $action = Auth::user()->can(['store-edit', 'store-delete']);

        return view('department.show')->with(compact('department', 'stores', 'action'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $department = Department::findOrFail($id);

        return view('department.form')->with(compact('department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param DepartmentRequest $request
     * @return Response
     */
    public function update($id, DepartmentRequest $request)
    {
        $department = Department::findOrFail($id);
        $department->update($request->all());

        return redirect(route('department.index'))->withFlashMessage(trans('department.msg.updated', ['name' => $department->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        if ($department->stores->count() > 0)
            return response()->json([
                'state' => 'not_deleted',
                'flash' => HtmlEx::alert(trans('department.msg.has_stores', ['name' => $department->name]), 'danger', true),
            ]);
        else {
            Session::flash('flash_message', trans('department.msg.deleted', ['name' => $department->name]));
            $department->delete();
            return response()->json([
                'state' => 'deleted',
                'redirect' => route('department.index')
            ]);
        }
    }
}
