<?php

namespace ChemLab\DataTables;

use ChemLab\DataTables\BaseDataTable;
use OwenIt\Auditing\Models\Audit;
use Yajra\DataTables\EloquentDataTable;
use Illuminate\Support\Str;

class AuditsDataTable extends BaseDataTable
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
        $dt->addColumn('username', function (Audit $audit) {
            if (is_null($audit->user_id))
                return __('users.guest');

            return $audit->user ? $audit->user->name : __('audits.deleted', ['id' => $audit->user_id]);
        })->editColumn('auditable_type', function (Audit $audit) {
            return __(Str::plural(strtolower(str_replace('ChemLab\\', '', $audit->auditable_type))) . '.title');
        })->addColumn('auditable_name', function (Audit $audit) {
            $auditable = $audit->auditable;
            if (!$auditable)
                return __('audits.deleted', ['id' => $audit->auditable_id]);
            else {
                return $audit->auditable->name ?? $audit->auditable->title ?? $audit->auditable->id;
            }
        })->addColumn('action', function (Audit $audit) {
            return view('partials.actions.show', ['resource' => 'audits', 'entry' => $audit])->render();
        });

        return $dt;
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = Audit::with([
            'auditable' => function ($wQuery) {
                $wQuery->withTrashed();
            }, 'user' => function ($wQuery) {
                $wQuery->withTrashed();
            }]);
        $query = Audit::query();

        /*$request = $this->request()->input('search');
        foreach ($request as $key => $value) {
            switch ($key) {
                case 'string':
                    $query->OfString($value, ['audits.name', 'audits.display_name']);
                    break;
                case 'id':
                    $query->OfColumn($key, $value);
                    break;
            }
        }*/

        return $query;
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
                'data' => 'username',
                'name' => 'username',
                'title' => trans('user.title')
            ],
            [
                'data' => 'auditable_type',
                'name' => 'auditable_type',
                'title' => trans('audits.type')
            ],
            [
                'data' => 'auditable_name',
                'name' => 'auditable_name',
                'title' => trans('audits.name')
            ],
            [
                'data' => 'event',
                'name' => 'event',
                'title' => trans('audits.event')
            ],
            [
                'data' => 'created_at',
                'name' => 'created_at',
                'title' => trans('common.created_at')
            ]
        ]);
    }

    /**
     * Get DataTable parameters.
     *
     * @return array
     */
    protected function getParameters()
    {
        return array_merge(parent::getParameters(), ['order' => [[count($this->getColumns()) - 1, 'desc']]]);
    }
}