<?php

namespace ChemLab\DataTables;

use Carbon\Carbon;
use ChemLab\Chemical;
use ChemLab\Helpers\Html;
use Yajra\DataTables\EloquentDataTable;

class ChemicalDataTable extends BaseDataTable
{
    protected $grouped = false;

    /**
     * DataTable
     *
     * @param $query
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable($query)
    {
        $user = auth()->user();
        $show = $user->can('chemical-show');
        $edit = $user->can('chemical-edit');

        $dt = new EloquentDataTable($query);
        return $dt->editColumn('name', function (Chemical $chemical) {
            return link_to_route('chemical.show', str_limit($chemical->name, 40, '...'), ['id' => $chemical->id]);
        })->editColumn('catalog_id', function (Chemical $chemical) {
            return $chemical->formatBrandLink();
        })->editColumn('store_name', function (Chemical $chemical) {
            return str_limit($chemical->store_name, 30, '...');

            /*$stores = explode(',', $chemical->store_name);
            $store = str_limit($stores[0], 35, '...');
            if (count($stores) > 1)
                $store .= "<a data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Tooltip on left\">(" . count($stores) .")</a>";

            return $store;*/
        })->editColumn('amount', function (Chemical $chemical) {
            return Html::unit($chemical->unit, $chemical->amount);
        })->addColumn('action', function ($item) use ($show, $edit) {
            $resource = $this->getResource();
            $html = view('partials.actions.show', ['resource' => $resource, 'entry' => $item, 'pass' => $show])->render() . " "
                . view('partials.actions.edit', ['resource' => $resource, 'entry' => $item, 'pass' => $show])->render() . " ";

            if (auth()->user()->canManageStore($this->grouped ? explode(';', $item->store_id) : $item->store_id)) {
                $html .= view('partials.actions.delete', ['resource' => $this->grouped ? $resource : 'chemical-item', 'entry' => $item, 'response' => 'dt'])->render();
            }

            return $html;
        });
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = Chemical::with('brand')->listJoin();

        $request = $this->request()->input('search');
        if (!array_key_exists('attrs', $request))
            $request['attrs'] = ['group'];

        foreach ($request as $key => $value) {
            switch ($key) {
                case 'string':
                    $query->search($value);
                    break;
                case 'store':
                    $query->ofStore($value);
                    break;
                case 'attrs':
                    if (in_array('group', $value)) {
                        $query->groupSelect();
                        $this->grouped = true;
                    } else
                        $query->nonGroupSelect();

                    if (in_array('recent', $value))
                        $query->recent(Carbon::now()->subDays(30));
                    break;
                case 'chemspider':
                case 'pubchem':
                case 'formula':
                    $query->where('chemicals.' . $key, 'LIKE', "%" . $value . "%");
                    break;
                case 'inchikey':
                    $query->structureJoin()->where('chemical_structures.' . $key, 'LIKE', "%" . $value . "%");
                    break;
                default:
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
                'title' => trans('chemical.name'),
                'class' => 'word-break',
            ],
            [
                'data' => 'catalog_id',
                'name' => 'catalog_id',
                'title' => trans('chemical.brand.id'),
                'orderable' => true
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
                'data' => 'date',
                'name' => 'date',
                'title' => 'date',
                'visible' => false,
                'render' => null,
                'orderable' => true,
                'searchable' => false,
                'exportable' => false,
                'printable' => false,
            ]
        ]);
    }

    /*protected function getParameters()
    {
        return array_merge(parent::getParameters(), [
            'order' => [[sizeof($this->getColumns()) - 1, 'desc']]
        ]);
    }*/
}
