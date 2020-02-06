<?php

namespace ChemLab\Http\Resources\ChemicalItem;

use ChemLab\Http\Resources\Chemical\EntryResource as ChemicalResource;
use ChemLab\Http\Resources\JsonResource;
use ChemLab\Http\Resources\Store\EntryResource as StoreEntry;
use ChemLab\Http\Resources\User\EntryResource as UserEntry;
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
            'chemical_id' => $this->chemical_id,
            'chemical' => new ChemicalResource($this->whenLoaded('chemical')),
            'store_id' => $this->store_id,
            'store' => new StoreEntry($this->whenLoaded('store')),
            'amount' => $this->amount,
            'unit' => $this->unit,
            'owner_id' => $this->unit,
            'owner' => new UserEntry($this->whenLoaded('owner'))
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param Request $request
     * @return array
     */
    /* public function with($request): array
    {
        $user = auth()->user();
        return [
            'refs' => [
                'stores' => $user->getManageableStoreList('chemicals-edit'),
                'brands' => Brand::select('id', 'name')->orderBy('name')->get()->prepend(['id' => null, 'name' => __('common.not.selected')]),
                'users' => User::select('id', 'name')->orderBy('name')->get()->prepend(['id' => null, 'name' => __('common.not.selected')])
            ]
        ];
    }*/
}
