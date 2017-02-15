<?php

namespace ChemLab\DataTables;

use Yajra\Datatables\Services\DataTable;

abstract class BaseDataTable extends DataTable
{
    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    abstract public function ajax();

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
            'class' => 'table table-striped table-hover table-list ' . $this->getModule(),
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
            'defaultContent' => '',
            'name' => 'checkbox',
            'title' => '',
            'orderable' => false,
            'printable' => false,
            'searchable' => false,
        ]];
    }

    protected function getParameters()
    {
        return [
            'dom' => 'tr<"panel-footer"<"row"<"col-sm-12"lp>>>',
            'pageLength' => '25',
            //'pagingType' => 'full_numbers',
            'searchDelay' => 400,
            'columnDefs' => [
                [
                    'orderable' => false,
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

    public function addActionData($resource, $checkbox = true)
    {
        $resource->addColumn('action', function ($item) {
            $module = $this->getModule();
            return view('partials.actions', ['module' => $module, 'item' => $item])->render();
        });
        /*if ($checkbox)
        {
            $resource->addColumn('checkbox', function($item) {
                return '<input type="hidden" value=\"'.$item->id.'\">';
            });
        }*/

        return $resource;
    }
}
