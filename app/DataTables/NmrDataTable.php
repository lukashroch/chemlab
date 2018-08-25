<?php

namespace ChemLab\DataTables;

use ChemLab\Nmr;
use Yajra\DataTables\EloquentDataTable;

class NmrDataTable extends BaseDataTable
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
        return $dt->rawColumns(['name', 'action'])->editColumn('name', function (Nmr $nmr) {
            return "<a href=\"" . route('nmr.download', ['id' => $nmr->id]) . "\" title=\"" . trans('nmr.download') . "\" >
                    <span class=\"fas fa-file-zip-o\" aria-hidden=\"true\" ></span> {$nmr->getName()}</a>";
        })->editColumn('content', function (Nmr $nmr) {
            return str_limit($nmr->content, 50, '...');
        })->addColumn('action', function (Nmr $nmr) {
            $resource = $this->getResource();
            return view('partials.actions.download', ['resource' => $resource, 'entry' => $nmr])->render()
                . " " . view('partials.actions.delete', ['resource' => $resource, 'entry' => $nmr, 'response' => 'dt'])->render();
        });
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = Nmr::select('nmrs.*', 'users.name as user', 'ops.name as operator')
            ->join('users', 'nmrs.user_id', '=', 'users.id')
            ->join('users as ops', 'nmrs.created_by', '=', 'ops.id');

        $users = [];
        if (auth()->user()->hasPermission('nmr-show-all')) {
            $request = $this->request()->input('search');
            if (array_key_exists('user', $request) && !empty($request['user'])) {
                $users = $request['user'];
            }
        } else
            $users[] = auth()->id();

        $query->ofUser($users);

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
                'title' => trans('common.name'),
                'orderable' => false
            ],
            [
                'data' => 'content',
                'name' => 'content',
                'title' => trans('nmr.content')
            ],
            [
                'data' => 'user',
                'name' => 'user',
                'title' => trans('user.title'),
                'visible' => auth()->user()->hasPermission('nmr-show-all')
            ],
            [
                'data' => 'operator',
                'name' => 'operator',
                'title' => trans('nmr.operator'),
                'visible' => false
            ],
            [
                'data' => 'created_at',
                'name' => 'created_at',
                'title' => trans('common.date')
            ]
        ]);
    }

    protected function getParameters()
    {
        return array_merge(parent::getParameters(), [
            'order' => [[sizeof($this->getColumns()) - 1, 'desc']]
        ]);
    }
}
