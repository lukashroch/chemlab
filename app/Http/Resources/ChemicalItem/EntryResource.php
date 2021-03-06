<?php

namespace ChemLab\Http\Resources\ChemicalItem;

use ChemLab\Http\Resources\BaseListResource;
use ChemLab\Http\Resources\Chemical\EntryResource as ChemicalResource;
use ChemLab\Http\Resources\Store\EntryResource as StoreEntry;
use ChemLab\Http\Resources\User\EntryResource as UserEntry;
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
        $user = auth()->user();

        return [
            'id' => $this->id,
            'chemical_id' => $this->chemical_id,
            'chemical' => new ChemicalResource($this->whenLoaded('chemical')),
            'store_id' => $this->store_id,
            'store' => new StoreEntry($this->whenLoaded('store')),
            'amount' => $this->amount,
            'unit' => $this->unit,
            'owner_id' => $this->owner_id,
            'owner' => new UserEntry($this->whenLoaded('owner')),
            'created_at' => $this->created_at,
            'perm' => [
                'edit' => $user->hasPermission('chemicals-edit', $this->store->team_id),
                'delete' => $user->hasPermission('chemicals-delete', $this->store->team_id)
            ]
        ];
    }
}
