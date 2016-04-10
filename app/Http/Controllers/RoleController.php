<?php namespace ChemLab\Http\Controllers;

use ChemLab\Http\Requests\RoleRequest;
use ChemLab\Permission;
use ChemLab\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class RoleController extends ResourceController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $str = Input::get('search');
        $roles = Role::orderBy('name', 'asc')
            ->where('name', 'LIKE', "%" . $str . "%")
            ->orWhere('display_name', 'LIKE', "%" . $str . "%")
            ->paginate(Auth::user()->listing)
            ->appends(Input::All());

        $action = Auth::user()->can(['role-edit', 'role-delete']);

        return view('role.index')->with(compact('roles', 'action'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('role.form')->with(['role' => new Role()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleRequest $request
     * @return Response
     */
    public function store(RoleRequest $request)
    {
        $role = new Role();
        $role->name = $request->input('name');
        $role->display_name = $request->input('display_name');
        $role->description = $request->input('description');
        $role->save();

        return redirect(route('role.edit', ['id' => $role->id]))->withFlashMessage(trans('role.msg.inserted', ['name' => $role->name]));
    }

    /**
     * Display the specified resource.
     *
     * @param  Role $role
     * @return Response
     */
    public function show(Role $role)
    {
        $role->load('perms', 'users');
        return view('role.show')->with(compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Role $role
     * @return Response
     */
    public function edit(Role $role)
    {
        $role->load('perms');
        $perms = Permission::whereNotIn('id', $role->perms->pluck('id'))->orderBy('name')->get();
        return view('role.form')->with(compact('role', 'perms'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Role $role
     * @param RoleRequest $request
     * @return Response
     */
    public function update(Role $role, RoleRequest $request)
    {
        $role->display_name = $request->input('display_name');
        $role->description = $request->input('description');
        $role->save();

        return redirect(route('role.index'))->withFlashMessage(trans('role.msg.updated', ['name' => $role->display_name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Role $role
     * @return Response
     */
    public function destroy(Role $role)
    {
        return response()->json([
            'state' => false,
            'alert' => ['type' => 'warning', 'str' => trans('role.msg.deleted.disabled')]
        ]);
    }
}
