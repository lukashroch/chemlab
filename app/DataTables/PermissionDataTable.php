<?php

namespace ChemLab\DataTables;

use ChemLab\Permission;

class PermissionDataTable extends BaseDataTable
{
    protected function getModule()
    {
        return 'permission';
    }

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        $res = $this->datatables->of($this->query());

        return $this->addActionData($res)->make(true);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = Permission::query();

        if ($this->request()->has('s')) {
            $str = $this->request()->get('s');
            $query->where('name', 'LIKE', "%" . $str . "%")
                ->orWhere('display_name', 'LIKE', "%" . $str . "%");
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

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'permissions_' . time();
    }
}
