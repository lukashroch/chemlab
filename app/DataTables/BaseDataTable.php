<?php

namespace ChemLab\DataTables;

use Yajra\DataTables\Services\DataTable;

class BaseDataTable extends DataTable
{
    /**
     * Get mapped columns versus final decorated output.
     * Override default 'printable' to 'exportable' to get rid of formatted data for print
     *
     * @return array
     */
    protected function getDataForPrint()
    {
        $columns = $this->printColumns();

        return $this->mapResponseToColumns($columns, 'exportable');
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

    protected function getTableAttributes()
    {
        return [
            'id' => 'data-table',
            'class' => 'table table-sm table-striped table-hover table-list ' . $this->getResource(),
            'width' => '100%'
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

    protected function getParameters()
    {
        return [
            'dom' => '<"row"<"col-sm-12"rt>><"card-footer"<"row"<"col-md-4"l><"col-md-8"p>>>',
            'pageLength' => auth()->user()->settings()->get('listing'),
            'language' => trans('datatables'),
            //'pagingType' => 'full_numbers',
            //'searchDelay' => 400,
            'select' => [
                'style' => 'multi',
                'selector' => 'td:first-child',
            ],
            'order' => [[1, 'asc']]
        ];
    }

    protected function addActionData($resource)
    {
        $resource->addColumn('action', function ($entry) {
            $resource = $this->getResource();
            return view('partials.actions.show', ['resource' => $resource, 'entry' => $entry])->render()
                . " " . view('partials.actions.edit', ['resource' => $resource, 'entry' => $entry])->render()
                . " " . view('partials.actions.delete', ['resource' => $resource, 'entry' => $entry, 'response' => 'dt'])->render();
        });

        return $resource;
    }

    protected function getResource()
    {
        return strtolower(str_replace('DataTable', '', class_basename(static::class)));
    }
}
