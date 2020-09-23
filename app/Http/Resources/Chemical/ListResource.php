<?php

namespace ChemLab\Http\Resources\Chemical;

use ChemLab\Helpers\Helper;
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
        $user = auth()->user();

        return [
            'id' => $this->id,
            'item_id' => $this->item_id,
            'name' => $this->name,
            'catalog_id' => $this->catalog_id,
            'store' => $this->store,
            'amount' => Helper::unit($this->unit, $this->amount),
            'perm' => [
                'edit' => $user->hasPermission('chemicals-edit', $this->team),
                'delete' => $user->hasPermission('chemicals-delete', $this->team)
            ]
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
            'item_id' => $this->item_id,
            'name' => $this->name,
            'amount' => Helper::unit($this->unit, $this->amount),
            'store' => $this->store,
            'iupac' => $this->iupac,
            'brand' => $this->brand,
            'catalog_id' => $this->catalog_id,
            'cas' => $this->cas,
            'chemspider' => $this->chemspider,
            'pubchem' => $this->pubchem,
            'mw' => $this->mw,
            'formula' => $this->formula,
            'synonym' => $this->synonym,
            'description' => $this->description,
            'symbol' => implode(', ', $this->symbol),
            'signal_word' => $this->signal_word,
            'h' => implode(', ', $this->h),
            'p' => implode(', ', $this->h)
        ];
    }
}
