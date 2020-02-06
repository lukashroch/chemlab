<?php

namespace ChemLab\Http\Resources\ChemicalItem;

use ChemLab\Helpers\Helper;
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
            'catalog_id' => $this->catalog_id,
            'iupac_name' => $this->iupac_name,
            'brand_id' => $this->brand_id,
            'brand' => $this->whenLoaded('brand'),
            'store' => $this->store_name,
            'amount' => Helper::unit($this->unit, $this->amount)
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
            'iupac_name' => $this->iupac_name,
            'brand_id' => $this->brand_id,
            'brand' => $this->whenLoaded('brand'),
            'catalog_id' => $this->catalog_id,
            'cas' => $this->cas,
            'chemspider' => $this->chemspider,
            'pubchem' => $this->pubchem,
            'mw' => $this->mw,
            'formula' => $this->formula,
            'synonym' => $this->synonym,
            'description' => $this->description,
            'symbol' => $this->symbol,
            'signal_word' => $this->signal_word,
            'h' => $this->h,
            'p' => $this->p,
            'r' => $this->r,
            's' => $this->s
        ];
    }
}
