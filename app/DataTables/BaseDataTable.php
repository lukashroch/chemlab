<?php

namespace ChemLab\DataTables;

use ChemLab\Helpers\Html;
use Yajra\Datatables\Services\DataTable;

abstract class BaseDataTable extends DataTable
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
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    abstract public function query();

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            //->addCheckbox(['printable' => false])
            ->columns($this->getColumns())
            ->ajax('')
            ->addAction(['printable' => false])
            ->parameters($this->getParameters())
            ->setTableAttributes($this->getTableAttributes());
    }

    protected function getTableAttributes()
    {
        return [
            'id' => 'data-table',
            'class' => 'table table-sm table-striped table-hover table-list ' . $this->getModule(),
            'width' => '100%'
        ];
    }

    /**
     * Get columns.
     *
     * @return array
     */
    abstract protected function getColumns();

    protected function getCheckBoxColumn()
    {
        return [[
            'data' => null,
            'defaultContent' => ' ',
            'name' => 'checkbox',
            'title' => '',
            'orderable' => false,
            'printable' => false,
            'exportable' => false,
            'searchable' => false,
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
            'columnDefs' => [
                [
                    'className' => 'select-checkbox',
                    'targets' => [0]
                ]
            ],
            'select' => [
                'style' => 'multi',
                'selector' => 'td:first-child',
            ],
            'order' => [[1, 'asc']]
        ];
    }

    abstract protected function getModule();

    protected function addActionData($resource)
    {
        $resource->addColumn('action', function ($item) {
            $module = $this->getModule();
            return Html::icon($module . '.show', ['id' => $item->id]) . " "
                . Html::icon($module . '.edit', ['id' => $item->id]) . " "
                . Html::icon($module . '.delete', ['id' => $item->id, 'name' => $item->name, 'response' => 'dt']);

            //return view('partials.actions', ['module' => $module, 'item' => $item])->render();
        });

        return $resource;
    }
}
