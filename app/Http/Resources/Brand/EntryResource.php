<?php

namespace ChemLab\Http\Resources\Brand;

use ChemLab\Helpers\Parser\Parser;
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
            'url_product' => $this->url_product,
            'url_sds' => $this->url_sds,
            'parse_callback' => $this->parse_callback,
            'description' => $this->description
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param Request $request
     * @return array
     */
    public function with($request): array
    {
        return [
            'refs' => [
                'callbacks' => Parser::getParseCallbacks()
            ]
        ];
    }
}
