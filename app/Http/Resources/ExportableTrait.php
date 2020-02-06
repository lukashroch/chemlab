<?php

namespace ChemLab\Http\Resources;

trait ExportableTrait
{
    public function export(): array
    {
        return array_merge($this->exportDefaults(), $this->toExport());
    }

    public function exportDefaults(): array
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at->format('d.m.Y H:i:s'),
            'updated_at' => $this->updated_at->format('d.m.Y H:i:s')
        ];
    }
}
