<?php

namespace ChemLab\Http\Resources\Permission;

use ChemLab\Http\Resources\JsonResource;
use ChemLab\Http\Resources\Role\EntryResource as RoleResource;
use Illuminate\Http\Request;

class EntryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'display_name' => $this->display_name,
            'description' => $this->description,
            'roles' => RoleResource::collection($this->whenLoaded('roles'))
        ];
    }
}
