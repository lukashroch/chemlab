<?php

namespace ChemLab\Http\Controllers;

use ChemLab\DataTables\PermissionDataTable;
use ChemLab\Http\Requests\PermissionRequest;
use ChemLab\Permission;
use ChemLab\Role;

class PermissionController extends ResourceController
{
    /**
     * Display a listing of the resource.
     *
     * @param PermissionDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(PermissionDataTable $dataTable)
    {
        return $dataTable->render('permission.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('permission.form', ['permission' => new Permission()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PermissionRequest $request
     * @return \Illuminate\View\View
     */
    public function store(PermissionRequest $request)
    {
        $permission = Permission::create($request->all());

        // Always attach new permission to admin role
        $role = Role::where('name', 'admin')->firstOrFail();
        $role->attachPermission($permission);

        return redirect(route('permission.index'))->withFlashMessage(trans('permission.msg.inserted', ['name' => $permission->name]));
    }

    /**
     * Display the specified resource.
     *
     * @param Permission $permission
     * @return \Illuminate\View\View
     */
    public function show(Permission $permission)
    {
        $permission->load('roles');
        return view('permission.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Permission $permission
     * @return \Illuminate\View\View
     */
    public function edit(Permission $permission)
    {
        //$roles = Role::whereNotIn('id', $permission->roles->pluck('id'))->orderBy('display_name')->get();

        return view('permission.form', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Permission $permission
     * @param PermissionRequest $request
     * @return \Illuminate\View\View
     */
    public function update(Permission $permission, PermissionRequest $request)
    {
        $permission->update($request->all());
        $permission->save();

        return redirect(route('permission.index'))->withFlashMessage(trans('permission.msg.updated', ['name' => $permission->display_name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Permission $permission
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Permission $permission)
    {
        return response()->json([
            'type' => 'error',
            'alert' => ['type' => 'warning', 'text' => trans('permission.msg.deleted.disabled')]
        ]);

        //return $this->remove($permission);
    }
}
