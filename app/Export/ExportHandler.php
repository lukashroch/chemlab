<?php

namespace ChemLab\Export;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportHandler implements FromCollection, WithHeadings
{
    use Exportable;

    /**
     * @var Collection
     */
    protected $collection;

    /**
     * ExportHandler constructor.
     *
     * @param Collection $collection
     */
    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        return $this->collection;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        $first = $this->collection->first();
        if ($first) {
            return array_keys($first);
        }

        return [];
    }
}
