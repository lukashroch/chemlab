<?php

namespace ChemLab\Http\Controllers\ACL;

use ChemLab\Http\Controllers\ResourceController;
use ChemLab\Http\Requests\RoleRequest;
use ChemLab\Http\Resources\Role\EntryResource;
use ChemLab\Models\Permission;
use ChemLab\Models\Role;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class RoleController extends ResourceController
{
    /**
     *
     * @param Role $role
     */
    public function __construct(Role $role)
    {
        parent::__construct($role);
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
        return new EntryResource(new Role());
    }

    /**
     * Store a newly created resource in storage
     *
     * @param RoleRequest $request
     * @return EntryResource
     */
    public function store(RoleRequest $request): EntryResource
    {
        $role = new Role();
        $role->name = $request->input('name');
        $role->display_name = $request->input('display_name');
        $role->description = $request->input('description');
        $role->save();
        $role->permissions()->sync($request->input('permissions'));

        return new EntryResource($role->load('permissions'));
    }

    /**
     * Display the specified resource
     *
     * @param Role $role
     * @return EntryResource
     */
    public function show(Role $role): EntryResource
    {
        return new EntryResource($role->load('permissions'));
    }

    /**
     * Show the form for editing the specified resource
     *
     * @param Role $role
     * @return EntryResource
     */
    public function edit(Role $role): EntryResource
    {
        return new EntryResource($role->load('permissions'));
    }

    /**
     * Update the specified resource in storage
     *
     * @param Role $role
     * @param RoleRequest $request
     * @return EntryResource
     */
    public function update(Role $role, RoleRequest $request): EntryResource
    {
        $role->update($request->only(['display_name', 'description']));
        if (config('chemlab.superadmin') == $role->name) {
            $role->permissions()->sync(Permission::pluck('id'));
        } else
            $role->permissions()->sync($request->input('permissions'));

        return new EntryResource($role->load('permissions'));
    }

    /**
     * Remove the specified resource from storage
     *
     * @param Role $role
     * @return JsonResponse
     * @throws Exception
     */
    public function delete(Role $role = null): JsonResponse
    {
        if (config('chemlab.superadmin') == $role->name)
            return response()->json(['message' => __('common.error.not-allowed')], 403);

        return $this->triggerDelete($role);
    }
}
