<?php

namespace ChemLab\Http\Resources\Team;

use ChemLab\Http\Resources\JsonResource;
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
            'description' => $this->description
        ];
    }
}
