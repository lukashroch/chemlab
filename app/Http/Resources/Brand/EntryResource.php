<?php

namespace ChemLab\Http\Resources\Brand;

use ChemLab\Helpers\Parser\Parser;
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
            'url_product' => $this->url_product,
            'url_sds' => $this->url_sds,
            'parse_callback' => $this->parse_callback,
            'description' => $this->description
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
        return [
            'refs' => [
                'callbacks' => Parser::getParseCallbacks()
            ]
        ];
    }
}
