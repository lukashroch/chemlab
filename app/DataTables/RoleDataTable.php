<?php

namespace ChemLab\DataTables;

use ChemLab\Role;
use Yajra\DataTables\EloquentDataTable;

class RoleDataTable extends BaseDataTable
{
    /**
     * DataTable
     *
     * @param $query
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
        $query = Role::query();

        $request = $this->request()->input('search');
        if (array_key_exists('string', $request) && !empty($request['string'])) {
            $query->where('name', 'LIKE', "%" . $request['string'] . "%")
                ->orWhere('display_name', 'LIKE', "%" . $request['string'] . "%");
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
                'title' => trans('role.name.internal')
            ],
            [
                'data' => 'display_name',
                'name' => 'display_name',
                'title' => trans('role.name')
            ]
        ]);
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'roles_' . time();
    }
}
