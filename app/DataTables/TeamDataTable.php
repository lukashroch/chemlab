<?php

namespace ChemLab\DataTables;

use ChemLab\Team;
use Yajra\DataTables\EloquentDataTable;

class TeamDataTable extends BaseDataTable
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
        $query = Team::query();

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
                'title' => trans('team.name.internal')
            ],
            [
                'data' => 'display_name',
                'name' => 'display_name',
                'title' => trans('team.name')
            ]
        ]);
    }
}
