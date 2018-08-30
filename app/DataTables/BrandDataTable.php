<?php

namespace ChemLab\DataTables;

use ChemLab\Brand;
use Yajra\DataTables\EloquentDataTable;

class BrandDataTable extends BaseDataTable
{
    /**
     * DataTable
     *
     * @param $query
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable($query)
    {
        return $this->addActionData(new EloquentDataTable($query));
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = Brand::query();

        $request = $this->request()->input('search');
        foreach ($request as $key => $value) {
            switch ($key) {
                case 'string':
                    $query->OfString($value, ['brands.name']);
                    break;
                case 'id':
                    $query->OfColumn($key, $value);
                    break;
            }
        }

        return $this->applyScopes($query);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return array_merge($this->getCheckBoxColumn(), [
            [
                'data' => 'name',
                'name' => 'name',
                'title' => trans('brand.name')
            ],
            [
                'data' => 'description',
                'name' => 'description',
                'title' => trans('brand.description')
            ]
        ]);
    }
}
