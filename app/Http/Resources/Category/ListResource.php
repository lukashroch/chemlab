<?php

namespace ChemLab\Http\Resources\Category;

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
            'description' => $this->description
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
            'description' => $this->description
        ];
    }
}
