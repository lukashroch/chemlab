<?php

namespace ChemLab\Http\Resources\User;

use ChemLab\Http\Resources\JsonResource;
use Illuminate\Http\Request;

class ListResource extends JsonResource
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
            'email' => $this->email,
            'roles' => $this->roles->pluck('display_name'),
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
            'email' => $this->email,
            'roles' => implode(', ', $this->roles->pluck('display_name')->toArray())
        ];
    }
}
