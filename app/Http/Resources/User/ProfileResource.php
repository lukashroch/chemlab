<?php

namespace ChemLab\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'profile' => [
                'name' => $this->name,
                'email' => $this->email,
                'settings' => $this->settings,
                'socials' => $this->whenLoaded('socials'),
            ],
            'permissions' => $this->allPermissions()->pluck('name'),
        ];
    }
}
