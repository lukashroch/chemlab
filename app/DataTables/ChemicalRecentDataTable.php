<?php

namespace ChemLab\DataTables;

use Carbon\Carbon;
use ChemLab\Chemical;
use ChemLab\Helpers\Html;

class ChemicalRecentDataTable extends BaseDataTable
{
    protected function getModule()
    {
        return 'chemical';
    }

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        $res = $this->datatables
            ->of($this->query())
            ->editColumn('name', function (Chemical $chemical) {
                return str_limit($chemical->getDisplayNameWithDesc(), 30, '...');
            })
            ->editColumn('store_name', function (Chemical $chemical) {
                return str_limit($chemical->store_name, 30, '...');
            })
            ->editColumn('amount', function (Chemical $chemical) {
                return Html::unit($chemical->unit, $chemical->amount);
            })
            ->editColumn('created_at', function (Chemical $chemical) {
                return $chemical->created_at->formatLocalized('%d %b %Y (%H:%M)');
            });

        return $this->addActionData($res)->make(true);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = Chemical::select('chemicals.id', 'chemicals.name', 'chemicals.description',
            'chemical_items.amount', 'chemical_items.unit', 'chemical_items.created_at',
            'stores.tree_name as store_name')
            ->listJoin()->recent(Carbon::now()->subDays(30));

        if ($this->request()->has('s')) {
            $str = $this->request()->get('s');
            $query->search($str);
        }
        if ($this->request()->has('store')) {
            $query->ofStore($this->request()->get('store'));
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
                'title' => trans('chemical.name')
            ],
            [
                'data' => 'store_name',
                'name' => 'store_name',
                'title' => trans('store.title')
            ],
            [
                'data' => 'amount',
                'name' => 'amount',
                'title' => trans('chemical.amount'),
                'searchable' => false,
            ],
            [
                'data' => 'created_at',
                'name' => 'created_at',
                'title' => trans('chemical.date'),
                'searchable' => false
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
        return 'chemicals_recent_' . time();
    }
}
