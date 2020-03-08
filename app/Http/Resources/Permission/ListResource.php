<?php

namespace ChemLab\Http\Resources\Permission;

use ChemLab\Http\Resources\BaseListResource;
use Illuminate\Http\Request;

class ListResource extends BaseListResource
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
            'created_at' => $this->created_at->format('d.m.Y')
        ];
    }

    /**
     * Transform the resource into an array for export.
     *
     * @return array
     */
    public function toExport(): array
    {
        return [
            'name' => $this->name,
            'display_name' => $this->display_name,
            'description' => $this->description
        ];
    }
}
