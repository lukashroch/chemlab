<?php

namespace ChemLab\DataTables;

use ChemLab\Permission;
use Yajra\DataTables\EloquentDataTable;

class PermissionDataTable extends BaseDataTable
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
        $query = Permission::query();

        $request = $this->request()->input('search');
        foreach ($request as $key => $value) {
            switch ($key) {
                case 'string':
                    $query->OfString($value, ['permissions.name', 'permissions.display_name']);
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
                'title' => trans('role.name')
            ],
            [
                'data' => 'display_name',
                'name' => 'display_name',
                'title' => trans('role.name.internal')
            ]
        ]);
    }
}
