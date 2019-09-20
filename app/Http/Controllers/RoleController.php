<?php

namespace ChemLab\Http\Controllers;

use ChemLab\DataTables\RoleDataTable;
use ChemLab\Http\Requests\RoleRequest;
use ChemLab\Permission;
use ChemLab\Role;
use Prologue\Alerts\Facades\Alert;

class RoleController extends ResourceController
{
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
        $permissions = Permission::orderBy('name')->get();
        $permissions = $this->groupPermissions($permissions);
        return view('role.form', ['role' => new Role(), 'permissions' => $permissions]);
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
        $role->permissions()->sync($request->input('permissions'));

        Alert::success(trans('role.msg.inserted', ['name' => $role->display_name]))->flash();
        return redirect(route('role.edit', ['role' => $role->id]));
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
        $role->load('permissions');
        $permissions = Permission::orderBy('name')->get();
        $permissions = $this->groupPermissions($permissions);
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

        if ($role->name == config('chemlab.superadmin')) {
            $permissions = Permission::pluck('id');
            $role->permissions()->sync($permissions);
        } else
            $role->permissions()->sync($request->input('permissions'));

        Alert::success(trans('role.msg.updated', ['name' => $role->display_name]))->flash();
        return redirect(route('role.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Role $role)
    {
        if (config('chemlab.superadmin') == $role->name) {
            return response()->json([
                'status' => 'error',
                'errors' => [trans('common.error.not-allowed')]
            ], 403);
        }

        return $this->remove($role);
    }

    /**
     * Detach specified Permission to selected Role
     *
     * @param \Illuminate\Support\Collection $permissions
     * @return array
     */
    protected function groupPermissions($permissions)
    {
        $permGroups = [
            'general' => []
        ];
        foreach ($permissions as $permission) {
            $name = explode("-", $permission->name);
            if (count($name) == 1) {
                array_push($permGroups['general'], $permission);
            } else {
                if (key_exists($name[0], $permGroups) && is_array($permGroups[$name[0]]))
                    array_push($permGroups[$name[0]], $permission);
                else
                    $permGroups[$name[0]] = [$permission];
            }
        }

        return $permGroups;
    }
}
