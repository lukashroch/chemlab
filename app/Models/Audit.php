<?php

namespace ChemLab\Models;

use ChemLab\Export\Exportable;
use ChemLab\Export\ExportableTrait;
use ChemLab\Models\Traits\ActionableTrait;
use ChemLab\Models\Traits\ScopeTrait;
use OwenIt\Auditing\Models\Audit as BaseAudit;

class Audit extends BaseAudit implements Exportable
{
    use ActionableTrait, ExportableTrait, ScopeTrait;

    /**
     * Get actions based on current view
     *
     * @return array
     */
    public static function actions(): array
    {
        $actions = [
            'table' => ['show',],
            'toolbar' => ['show'],
        ];
        if (in_array(Exportable::class, class_implements(static::class)))
            array_push($actions['toolbar'], 'export');

        return $actions;
    }

    /**
     * Get export columns.
     *
     * @return array
     */
    public static function exportColumns(): array
    {
        return static::buildExportColumns([
            [
                'data' => 'name',
                'title' => __('common.name')
            ],
            [
                'data' => 'auditable_type',
                'title' => __('audits.type')
            ],
            [
                'data' => 'auditable_name',
                'title' => __('audits.name')
            ],
            [
                'data' => 'event',
                'title' => __('audits.event')
            ]
        ]);
    }
}
