<?php

namespace ChemLab\DataTables;

use ChemLab\Role;

class RoleDataTable extends BaseDataTable
{
    protected function getModule()
    {
        return 'role';
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
        return 'roles_' . time();
    }
}
