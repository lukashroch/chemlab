<?php namespace ChemLab\Http\Controllers;

use ChemLab\Http\Requests\PermissionRequest;
use ChemLab\Permission;
use ChemLab\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class PermissionController extends ResourceController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $str = Input::get('search');
        $permissions = Permission::orderBy('name', 'asc')
            ->where('name', 'LIKE', "%" . $str . "%")
            ->orWhere('display_name', 'LIKE', "%" . $str . "%")
            ->paginate(Auth::user()->listing)
            ->appends(Input::All());

        $action = Auth::user()->can(['permission-edit', 'permission-delete']);

        return view('permission.index')->with(compact('permissions', 'action'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('permission.form')->with(['permission' => new Permission()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PermissionRequest $request
     * @return Response
     */
    public function store(PermissionRequest $request)
    {
        $permission = new Permission();
        $permission->name = $request->input('name');
        $permission->display_name = $request->input('display_name');
        $permission->description = $request->input('description');
        $permission->save();

        // Always attach new permission to admin role
        $role = Role::where('name', 'admin')->firstOrFail();
        $role->attachPermission($permission);

        return redirect(route('permission.index'))->withFlashMessage(trans('permission.msg.inserted', ['name' => $permission->name]));
    }

    /**
     * Display the specified resource.
     *
     * @param  Permission $permission
     * @return Response
     */
    public function show(Permission $permission)
    {
        $permission->load('roles');
        return view('permission.show')->with(compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Permission $permission
     * @return Response
     */
    public function edit(Permission $permission)
    {
        //$roles = Role::whereNotIn('id', $permission->roles->pluck('id'))->orderBy('display_name')->get();

        return view('permission.form')->with(compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Permission $permission
     * @param PermissionRequest $request
     * @return Response
     */
    public function update(Permission $permission, PermissionRequest $request)
    {
        $permission->display_name = $request->input('display_name');
        $permission->description = $request->input('description');
        $permission->save();

        return redirect(route('permission.index'))->withFlashMessage(trans('permission.msg.updated', ['name' => $permission->display_name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Permission $permission
     * @return Response
     */
    public function destroy(Permission $permission)
    {
        return response()->json([
            'state' => false,
            'alert' => ['type' => 'warning', 'str' => trans('permission.msg.deleted.disabled')]
        ]);
    }
}
