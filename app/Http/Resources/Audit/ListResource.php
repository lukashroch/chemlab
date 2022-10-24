<?php

namespace ChemLab\Http\Resources\Audit;

use ChemLab\Http\Resources\BaseListResource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        if (is_null($this->user_id))
            $username = __('users.guest');
        else
            $username = $this->user ? $this->user->name : __('audits.deleted', ['id' => $this->user_id]);

        $auditable = $this->auditable;
        if (!$auditable)
            $auditable = __('audits.not-found', ['id' => $this->auditable_id]);
        else {
            $auditable = $this->auditable->name ?? $this->auditable->title ?? $this->auditable->id;
        }

        return [
            'id' => $this->id,
            'name' => $username,
            'auditable_type' => __(Str::plural(Str::kebab(class_basename($this->auditable_type))) . '.title'),
            'auditable_name' => $auditable,
            'event' => $this->event,
            'created_at' => $this->created_at->format('d.m.Y'),
            'deleted_at' => $this->deleted_at
        ];
    }

    /**
     * Transform the resource into an array for export.
     *
     * @return array
     */
    public function toExport(): array
    {
        if (is_null($this->user_id))
            $username = __('users.guest');
        else
            $username = $this->user ? $this->user->name : __('audits.deleted', ['id' => $this->user_id]);

        $auditable = $this->auditable;
        if (!$auditable)
            $auditable = __('audits.deleted', ['id' => $this->auditable_id]);
        else {
            $auditable = $this->auditable->name ?? $this->auditable->title ?? $this->auditable->id;
        }

        return [
            'name' => $username,
            'auditable_type' => __(Str::plural(Str::kebab(class_basename($this->auditable_type))) . '.title'),
            'auditable_name' => $auditable,
            'event' => $this->event
        ];
    }
}
