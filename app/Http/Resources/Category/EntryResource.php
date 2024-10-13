<?php

namespace ChemLab\Http\Resources\Category;

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
            'description' => $this->description
        ], parent::toArray($request));
    }
}
