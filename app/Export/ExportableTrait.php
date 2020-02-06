<?php

namespace ChemLab\Export;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

trait ExportableTrait
{
    /**
     * Prepare export
     *
     * @param array $columns
     * @return Export
     */
    public static function export($columns): Export
    {
        $exportColumns = array_filter(static::exportColumns(), function ($item) use ($columns) {
            return in_array($item['data'], $columns);
        });

        $export = new Export($exportColumns);
        $filename = Str::slug(__(Str::kebab(Str::plural(class_basename(static::class))) . '.index'));
        return $export->setFilename($filename);
    }

    /**
     * Prepare export columns
     *
     * @param array $columns
     * @return array
     */
    protected static function buildExportColumns($columns): array
    {
        $columns = array_merge(
            [
                [
                    'data' => 'id',
                    'title' => __('common.id')
                ]
            ],
            $columns,
            [
                [
                    'data' => 'created_at',
                    'title' => __('common.created_at')
                ],
                [
                    'data' => 'updated_at',
                    'title' => __('common.updated_at')
                ]
            ]);

        if (in_array(SoftDeletes::class, class_uses_recursive(static::class))) {
            array_push($columns, [
                'data' => 'deleted_at',
                'title' => __('common.deleted_at')
            ]);
        }

        return $columns;
    }
}
