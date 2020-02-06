<?php

namespace ChemLab\Export;

use Illuminate\Support\Collection;

class Export
{
    /**
     * Export columns
     *
     * @var Collection
     */
    protected $columns;

    /**
     * Export data
     *
     * @var array
     */
    protected $data;

    /**
     * Export filename.
     *
     * @var string
     */
    protected $filename = 'Export';

    /**
     * Export class handler
     *
     * @var string
     */
    protected $exportClass = ExportHandler::class;

    /**
     * CSV export type writer
     *
     * @var string
     */
    protected $csvWriter = 'Csv';

    /**
     * Excel export type writer
     *
     * @var string
     */
    protected $excelWriter = 'Xlsx';

    public function __construct(array $columns)
    {
        $this->columns = collect($columns);
    }

    /**
     * Get export filename
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename ?: $this->filename();
    }

    /**
     * Set export filename
     *
     * @param string $filename
     * @return Export
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename for export
     *
     * @return string
     */
    protected function filename()
    {
        return $this->getFilename() . '_' . date('Y-m-d_His');
    }

    /**
     * Get mapped columns versus final decorated output
     *
     * @param array $data
     * @param string $type
     * @return Export
     */
    public function mapData(array $data, $type = 'exportable')
    {
        $columns = $this->columns;
        $transformer = new DataArrayTransformer;

        $this->data = array_map(function ($row) use ($columns, $type, $transformer) {
            return $transformer->transform($row, $columns, $type);
        }, $data);

        return $this;
    }

    /**
     * Export results to Excel file
     *
     * @return mixed
     */
    public function excel()
    {
        $ext = '.' . strtolower($this->excelWriter);

        return $this->buildExcelFile()->download($this->filename() . $ext, $this->excelWriter);
    }

    /**
     * Build excel file and prepare for export
     *
     * @return \Maatwebsite\Excel\Concerns\Exportable
     */
    protected function buildExcelFile()
    {
        $dataForExport = collect($this->data);

        return new $this->exportClass($dataForExport);
    }

    /**
     * Export results to CSV file
     *
     * @return mixed
     */
    public function csv()
    {
        $ext = '.' . strtolower($this->csvWriter);

        return $this->buildExcelFile()->download($this->filename() . $ext, $this->csvWriter);
    }

    /**
     * Export results to print view
     *
     * @return mixed
     */
    public function print()
    {
        $data = $this->data;

        return view('print.table', compact('data'));
    }
}
