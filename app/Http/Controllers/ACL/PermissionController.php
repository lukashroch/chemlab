<?php

namespace ChemLab\Http\Controllers\ACL;

use ChemLab\Http\Controllers\ResourceController;
use ChemLab\Http\Requests\PermissionRequest;
use ChemLab\Http\Resources\Permission\EntryResource;
use ChemLab\Models\Permission;
use ChemLab\Models\Role;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


class PermissionController extends ResourceController
{
    /**
     *
     * @param Permission $permission
     */
    public function __construct(Permission $permission)
    {
        parent::__construct($permission);
    }

    /**
     * Resource listing
     *
     * @return JsonResource | BinaryFileResponse
     */
    public function index()
    {
        return $this->collection(['name', 'display_name']);
    }

    /**
     * Reference resource data
     *
     * @return JsonResponse
     */
    public function refs(): JsonResponse
    {
        return $this->refData();
    }

    /**
     * Show the form for creating a new resource
     *
     * @return EntryResource
     */
    public function create(): EntryResource
    {
        return new EntryResource(new Permission());
    }

    /**
     * Store a newly created resource in storage
     *
     * @param PermissionRequest $request
     * @return EntryResource
     */
    public function store(PermissionRequest $request): EntryResource
    {
        $permission = new Permission();
        $permission->name = $request->input('name');
        $permission->display_name = $request->input('display_name');
        $permission->description = $request->input('description');
        $permission->save();

        // Always attach new permission to superadmin role
        if ($role = Role::where('name', config('chemlab.superadmin'))->first())
            $role->attachPermission($permission);

        return new EntryResource($permission->load('roles'));
    }

    /**
     * Display the specified resource
     *
     * @param Permission $permission
     * @return EntryResource
     */
    public function show(Permission $permission): EntryResource
    {
        return new EntryResource($permission->load('roles'));
    }

    /**
     * Show the form for editing the specified resource
     *
     * @param Permission $permission
     * @return EntryResource
     */
    public function edit(Permission $permission): EntryResource
    {
        return new EntryResource($permission->load('roles'));
    }

    /**
     * Update the specified resource in storage
     *
     * @param Permission $permission
     * @param PermissionRequest $request
     * @return EntryResource
     */
    public function update(Permission $permission, PermissionRequest $request): EntryResource
    {
        $permission->update($request->only($permission->getFillable()));
        return new EntryResource($permission->load('roles'));
    }

    /**
     * Remove the specified resource from storage
     *
     * @param Permission $permission
     * @return JsonResponse
     * @throws Exception
     */
    public function delete(Permission $permission = null): JsonResponse
    {
        return $this->triggerDelete($permission);
    }
}
