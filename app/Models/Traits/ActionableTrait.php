<?php

namespace ChemLab\Models\Traits;

use ChemLab\Export\Exportable;

trait ActionableTrait
{
    /**
     * Get actions based on current view
     *
     * @return array
     */
    public static function actions(): array
    {
        $actions = [
            'table' => ['show', 'edit', 'delete'],
            'toolbar' => ['create', 'show', 'edit', 'delete'],
        ];
        if (in_array(Exportable::class, class_implements(static::class)))
            array_push($actions['toolbar'], 'export');

        return $actions;
    }
}
