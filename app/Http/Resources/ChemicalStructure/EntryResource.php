<?php

namespace ChemLab\Http\Resources\ChemicalStructure;

use ChemLab\Http\Resources\BaseListResource;
use Illuminate\Http\Request;


class EntryResource extends BaseListResource
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
            'inchi' => $this->inchi,
            'inchikey' => $this->inchikey,
            'sdf' => $this->sdf,
            'smiles' => $this->smiles,
        ];
    }
}
