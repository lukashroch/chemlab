<?php

namespace ChemLab\DataTables;

use ChemLab\Helpers\Html;
use ChemLab\Nmr;

class NmrDataTable extends BaseDataTable
{
    protected function getModule()
    {
        return 'nmr';
    }

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables->of($this->query())
            ->rawColumns(['name', 'action'])
            ->editColumn('name', function (Nmr $nmr) {
                return "<a href=\"" . route('nmr.download', ['id' => $nmr->id]) . "\" title=\"".trans('nmr.download')."\" >
                    <span class=\"fa fa-file-zip-o\" aria-hidden=\"true\" ></span> {$nmr->getName()}</a>";
            })
            ->editColumn('content', function (Nmr $nmr) {
                return str_limit($nmr->content, 50, '...');
            })
            ->addColumn('action', function (Nmr $nmr) {
                $module = $this->getModule();
                return Html::icon($module . '.download', ['id' => $nmr->id]) . " "
                    . Html::icon($module . '.delete', ['id' => $nmr->id, 'name' => $nmr->getName(), 'response' => 'dt']);
            })
            ->make(true);
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
        if (auth()->user()->can('nmr-show-all')) {
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
                'visible' => auth()->user()->can('nmr-show-all')
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

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'nmrs_' . time();
    }
}
