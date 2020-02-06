<?php

namespace ChemLab\Http\Resources\Job;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'queue' => $this->queue,
            'title' => $this->payload['displayName'],
            'payload' => $this->payload,
            'attempts' => $this->attempts,
            'reserved_at' => $this->reserved_at,
            'available_at' => $this->available_at->format('d.m.Y H:i'),
            'created_at' => $this->created_at->format('d.m.Y H:i')
        ];
    }
}
