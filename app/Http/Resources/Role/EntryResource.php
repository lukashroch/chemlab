<?php

namespace ChemLab\Http\Resources\Role;

use ChemLab\Http\Resources\BaseEntryResource;
use ChemLab\Http\Resources\Permission\EntryResource as PermissionResource;
use ChemLab\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class EntryResource extends BaseEntryResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return array_merge([
            'id' => $this->id,
            'name' => $this->name,
            'display_name' => $this->display_name,
            'description' => $this->description,
            'permissions' => PermissionResource::collection($this->whenLoaded('permissions')),
            'expires_at' => $this->whenPivotLoaded('role_user', function () {
                return $this->pivot->expires_at;
            })
        ], parent::toArray($request));
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param Request $request
     * @return array
     */
    public function with($request): array
    {
        // TODO: move grouped Permission list to model
        $permissions = Permission::orderBy('name')->get();
        $permissions = $this->groupPermissions($permissions);

        return [
            'refs' => [
                'permissions' => $permissions,
            ],
        ];
    }

    /**
     * Group permissions by resource
     *
     * @param Collection $permissions
     * @return array
     */
    protected function groupPermissions($permissions): array
    {
        $permGroups = [
            'general' => []
        ];
        foreach ($permissions as $permission) {
            $name = explode("-", $permission->name);
            if (count($name) == 1 || $name[1] == 'attachments') {
                array_push($permGroups['general'], $permission);
            } else {
                if (array_key_exists($name[0], $permGroups) && is_array($permGroups[$name[0]]))
                    array_push($permGroups[$name[0]], $permission);
                else
                    $permGroups[$name[0]] = [$permission];
            }
        }

        return $permGroups;
    }
}
