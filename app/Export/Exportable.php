<?php

namespace ChemLab\Export;

interface Exportable
{
    /**
     * Get all exportable model columns
     *
     * @return array
     */
    public static function exportColumns(): array;

    /**
     * Prepare export providing columns to export
     *
     * @param array $columns
     * @return Export
     */
    public static function export($columns): Export;
}
