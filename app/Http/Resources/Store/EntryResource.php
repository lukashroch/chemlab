<?php

namespace ChemLab\Http\Resources\Store;

use ChemLab\Http\Resources\JsonResource;
use ChemLab\Models\Store;
use ChemLab\Models\Team;
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
            'parent_id' => $this->parent_id,
            'parent' => $this->whenLoaded('parent'),
            'children' => $this->whenLoaded('children'),
            'team_id' => $this->team_id,
            'team' => $this->whenLoaded('team'),
            'name' => $this->name,
            'abbr_name' => $this->abbr_name,
            'tree_name' => $this->tree_name,
            'description' => $this->description,
            'temp_min' => $this->temp_min,
            'temp_max' => $this->temp_max
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
        $teams = auth()->user()->roles()->whereHas('permissions', function ($query) {
            $query->where('name', 'stores-create');
        })->pluck('team_id');

        return [
            'refs' => [
                'stores' => Store::selectList($teams)->prepend(['id' => null, 'name' => __('common.none')]),
                'teams' => Team::whereIn('id', $teams)->select('id', 'display_name as name')->get()->prepend(['id' => null, 'name' => __('common.none')]),
            ]
        ];
    }
}
