<?php

namespace ChemLab\DataTables;

use ChemLab\User;
use Yajra\DataTables\EloquentDataTable;

class UserDataTable extends BaseDataTable
{
    /**
     * DataTable
     *
     * @param $query
     */
    public function dataTable($query)
    {
        $dt = new EloquentDataTable($query);
        $dt->addColumn('roles', function (User $user) {
            return str_limit($user->roles->map(function ($role) {
                return $role->display_name;
            })->implode(', '), 30, '...');
        });
        return $this->addActionData($dt);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = User::query();

        $request = $this->request()->input('search');
        if (array_key_exists('string', $request) && !empty($request['string'])) {
            $query->where('name', 'LIKE', "%" . $request['string'] . "%")
                ->orWhere('email', 'LIKE', "%" . $request['string'] . "%");
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
                'title' => trans('user.name')
            ],
            [
                'data' => 'email',
                'name' => 'email',
                'title' => trans('user.email')
            ],
            [
                // TODO check out laravel-datatables quering to make those searchable
                'data' => 'roles',
                'name' => 'name',
                'title' => trans('user.roles'),
                'searchable' => false,
                'orderable' => false
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
        return 'users_' . time();
    }
}
