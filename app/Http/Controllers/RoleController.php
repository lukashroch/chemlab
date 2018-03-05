<?php

namespace ChemLab\Http\Controllers;

use ChemLab\DataTables\RoleDataTable;
use ChemLab\Http\Requests\RoleRequest;
use ChemLab\Permission;
use ChemLab\Role;

class RoleController extends ResourceController
{

    public function __construct()
    {
        parent::__construct();

        $this->middleware(['ajax', 'permission:permission-role-attach'])->only('attachPermission');
        $this->middleware(['ajax', 'permission:permission-role-detach'])->only('detachPermission');
    }

    /**
     * Display a listing of the resource.
     *
     * @param RoleDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(RoleDataTable $dataTable)
    {
        return $dataTable->render('role.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('role.form', ['role' => new Role()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleRequest $request
     * @return \Illuminate\View\View
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
     * @param Role $role
     * @return \Illuminate\View\View
     */
    public function show(Role $role)
    {
        $role->load(['permissions', 'users']);
        return view('role.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Role $role
     * @return \Illuminate\View\View
     */
    public function edit(Role $role)
    {
        $role->load(['permissions']);
        $permissions = Permission::whereNotIn('id', $role->permissions->pluck('id'))->orderBy('name')->get();
        return view('role.form', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Role $role
     * @param RoleRequest $request
     * @return \Illuminate\View\View
     */
    public function update(Role $role, RoleRequest $request)
    {
        $role->update($request->all());
        return redirect(route('role.index'))->withFlashMessage(trans('role.msg.updated', ['name' => $role->display_name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Role $role)
    {
        return response()->json([
            'type' => 'error',
            'alert' => ['type' => 'warning', 'text' => trans('role.msg.deleted.disabled')]
        ]);

        //return $this->remove($role);
    }

    /**
     * Attach specified Permission to selected Role
     *
     * @param Role $role
     * @param Permission $permission
     * @return \Illuminate\Http\JsonResponse
     */
    public function attachPermission(Role $role, Permission $permission)
    {
        if (auth()->user()->canHandlePermission($permission->name)) {
            $role->attachPermission($permission);
            return response()->json(['type' => 'success']);
        } else {
            return response()->json([
                'type' => 'error',
                'alert' => ['type' => 'danger', 'text' => trans('common.error')]
            ]);
        }
    }

    /**
     * Detach specified Permission to selected Role
     *
     * @param Role $role
     * @param Permission $permission
     * @return \Illuminate\Http\JsonResponse
     */
    public function detachPermission(Role $role, Permission $permission)
    {
        if (auth()->user()->canHandlePermission($permission->name, $role->name)) {
            $role->detachPermission($permission);
            return response()->json(['type' => 'success']);
        } else {
            return response()->json([
                'type' => 'error',
                'alert' => ['type' => 'danger', 'text' => trans('common.error')]
            ]);
        }
    }
}
