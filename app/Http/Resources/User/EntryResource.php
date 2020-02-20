<?php

namespace ChemLab\Http\Resources\User;

use ChemLab\Http\Resources\BaseEntryResource;
use ChemLab\Models\Role;
use ChemLab\Models\Team;
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
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'roles' => $this->whenLoaded('roles', $this->teamRoles())
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
        $roles = Role::select('id', 'name', 'display_name')->orderBy('name')->get();
        $teams = Team::select('id', 'name', 'display_name')->orderBy('name')->get();

        $team = new Team();
        $team->id = 0;
        $team->name = 'global';
        $team->display_name = 'Global';
        $teams->prepend($team);

        foreach ($teams as $team) {
            $team['roles'] = $roles;
        }

        $refs = [
            'teams' => $teams
        ];

        return compact('refs');
    }
}
