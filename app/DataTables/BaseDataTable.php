<?php

namespace ChemLab\DataTables;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BaseDataTable extends DataTable
{
    public function render($view, $data = [], $mergeData = [])
    {
        return parent::render($view, array_merge($data, ['columns' => $this->getDataColumns()]), $mergeData);
    }

    /**
     * Get mapped columns versus final decorated output.
     * Override default 'printable' to 'exportable' to get rid of formatted data for print
     *
     * @return array
     */
    protected function getDataForPrint()
    {
        $columns = $this->arrayToColumns('printable');

        return $this->mapResponseToColumns($columns, 'printable');
    }

    /**
     * Get mapped columns versus final decorated output.
     *
     * @return array
     */
    protected function getDataForExport()
    {
        $columns = $this->arrayToColumns('exportable');

        return $this->mapResponseToColumns($columns, 'exportable');
    }

    protected function arrayToColumns($type = 'printable')
    {
        $collection = new Collection();

        if (!method_exists($this, 'getDataColumns'))
            return $collection;

        $selectedCols = $this->request()->input('selected_cols', []);

        foreach ($this->getDataColumns() as $column) {
            if ($column[$type] && in_array($column['name'], $selectedCols))
                $collection->push(new Column($column));
        }

        return $collection;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            //->addCheckbox(['printable' => false])
            ->ajax([
                'url' => request()->url() . '/dt',
                'type' => 'POST',
                'data' => '{"_method":"GET"}',
                'beforeSend' => 'function (request) { request.setRequestHeader("X-CSRF-Token", $(\'meta[name="csrf-token"]\').attr(\'content\')); }'
            ])
            ->columns($this->getColumns())
            ->addAction(['printable' => false])
            ->parameters($this->getParameters())
            ->setTableAttributes($this->getTableAttributes());
    }

    /**
     * Get table attributes.
     *
     * @return array
     */
    protected function getTableAttributes()
    {
        return [
            'id' => 'data-table',
            'class' => 'table table-sm table-striped table-hover table-list ' . $this->getResource(),
            'width' => '100%',
            'data-default-order' => implode('-', $this->getParameters()['order'][0])
        ];
    }

    /**
     * Get columns definitions.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [];
    }

    /**
     * Get data columns definitions for export/print.
     *
     * @return array
     */
    public function getDataColumns()
    {
        $columns = $this->getColumns();

        // Add printable and exportable if not already present
        foreach ($columns as $key => $column) {
            $columns[$key] = array_merge([
                'printable' => true,
                'exportable' => true
            ], $column);
        }

        return array_filter($columns, function ($value, $key) {
            return $value['printable'] || $value['exportable'];
        }, ARRAY_FILTER_USE_BOTH);
    }

    /**
     * Get checkbox column.
     *
     * @return array
     */
    protected function getCheckBoxColumn()
    {
        return [[
            'data' => null,
            'defaultContent' => ' ',
            'name' => 'checkbox',
            'className' => 'select-checkbox',
            'title' => '',
            'orderable' => false,
            'printable' => false,
            'exportable' => false,
            'searchable' => false,
            'width' => '10px',
        ]];
    }

    /**
     * Get DataTable parameters.
     *
     * @return array
     */
    protected function getParameters()
    {
        return [
            'dom' => 'rt<"card-footer"<"row justify-content-end"<"col"l><"col"p>>>',
            'pageLength' => auth()->user()->settings()->get('listing'),
            'language' => trans('datatables'),
            'select' => [
                'style' => 'multi',
                'selector' => 'td:first-child',
            ],
            'order' => [[1, 'asc']]
        ];
    }

    /**
     * Add action data column.
     *
     * @param \Yajra\DataTables\EloquentDataTable $resource
     * @return mixed
     */
    protected function addActionData($resource)
    {
        $resource->addColumn('action', function ($entry) {
            $resource = $this->getResource();
            return view('partials.actions.show', ['resource' => $resource, 'entry' => $entry])->render()
                . " " . view('partials.actions.edit', ['resource' => $resource, 'entry' => $entry])->render()
                . " " . view('partials.actions.delete', ['resource' => $resource, 'entry' => $entry, 'response' => 'dt'])->render();
        });

        return $resource->with(['search' => $this->request()->input('search')]);
    }

    protected function getResource()
    {
        return strtolower(str_replace('DataTable', '', class_basename(static::class)));
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return $this->getResource() . '_' . Carbon::now();
    }
}
