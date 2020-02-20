<?php

namespace ChemLab\Http\Resources\Brand;

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
            'parse_callback' => $this->parse_callback,
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
            'url_product' => $this->url_product,
            'url_sds' => $this->url_sds,
            'parse_callback' => $this->parse_callback,
            'description' => $this->description
        ];
    }
}
