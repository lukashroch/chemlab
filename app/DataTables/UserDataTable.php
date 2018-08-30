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
     * @return \Yajra\DataTables\EloquentDataTable
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
        $query = User::with('roles');

        $request = $this->request()->input('search');
        foreach ($request as $key => $value) {
            switch ($key) {
                case 'role':
                    $query->HasRoles(array_keys($value));
                    break;
                case 'string':
                    $query->OfString($value, ['users.name', 'users.email']);
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
                'title' => trans('user.name')
            ],
            [
                'data' => 'email',
                'name' => 'email',
                'title' => trans('user.email')
            ],
            [
                'data' => 'roles',
                'name' => 'roles',
                'title' => trans('user.roles'),
                'searchable' => false,
                'orderable' => false
            ]
        ]);
    }
}
