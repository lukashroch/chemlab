<?php

namespace ChemLab\Http\Resources\Team;

use ChemLab\Http\Resources\BaseEntryResource;
use Illuminate\Http\Request;

class EntryResource extends BaseEntryResource
{
    /**
     * Transform the resource into an array.
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
            'description' => $this->description
        ], parent::toArray($request));
    }
}
