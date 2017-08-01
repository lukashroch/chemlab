<?php

namespace ChemLab\Http\Controllers;

use ChemLab\DataTables\RoleDataTable;
use ChemLab\Http\Requests\RoleRequest;
use ChemLab\Permission;
use ChemLab\Role;
use ChemLab\Store;

class RoleController extends ResourceController
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware(['ajax', 'permission:role-edit'])->only(['attachPermission', 'detachPermission', 'attachStore', 'detachStore']);
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
        $role = Role::create($request->all());

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
        $role->load(['perms', 'users', 'stores']);
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
        $role->load(['perms', 'stores']);
        $perms = Permission::whereNotIn('id', $role->perms->pluck('id'))->orderBy('name')->get();
        $stores = Store::doesntHave('children')->whereNotIn('id', $role->stores->pluck('id'))->orderBy('tree_name')->get();
        return view('role.form', compact('role', 'perms', 'stores'));
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
     * @param Permission $perm
     * @return \Illuminate\Http\JsonResponse
     */
    public function attachPermission(Role $role, Permission $perm)
    {
        if (auth()->user()->canHandlePermission($perm->name)) {
            $role->attachPermission($perm);
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
     * @param Permission $perm
     * @return \Illuminate\Http\JsonResponse
     */
    public function detachPermission(Role $role, Permission $perm)
    {
        if (auth()->user()->canHandlePermission($perm->name, $role->name)) {
            $role->detachPermission($perm);
            return response()->json(['type' => 'success']);
        } else {
            return response()->json([
                'type' => 'error',
                'alert' => ['type' => 'danger', 'text' => trans('common.error')]
            ]);
        }
    }

    /**
     * Attach specified Store to selected Role
     *
     * @param Role $role
     * @param Store $store
     * @return \Illuminate\Http\JsonResponse
     */
    public function attachStore(Role $role, Store $store)
    {
        $role->stores()->attach($store->id);
        $role->touch();
        return response()->json(['type' => 'success']);
    }

    /**
     * Attach specified Store to selected Role
     *
     * @param Role $role
     * @param Store $store
     * @return \Illuminate\Http\JsonResponse
     */
    public function detachStore(Role $role, Store $store)
    {
        $role->stores()->detach($store->id);
        $role->touch();
        return response()->json(['type' => 'success']);
    }
}
