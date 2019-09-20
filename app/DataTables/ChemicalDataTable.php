<?php

namespace ChemLab\DataTables;

use Carbon\Carbon;
use ChemLab\Chemical;
use ChemLab\Helpers\Helper;
use Yajra\DataTables\EloquentDataTable;
use Illuminate\Support\Str;

class ChemicalDataTable extends BaseDataTable
{
    protected $grouped = false;
    protected $stores;
    protected $delStores;

    public function __construct()
    {
        $this->stores = auth()->user()->getManageableStores('chemical-show');
        $this->delStores = auth()->user()->getManageableStores('chemical-delete')->pluck('id')->toArray();
    }

    public function render($view, $data = [], $mergeData = [])
    {
        return parent::render($view, array_merge($data, ['stores' => $this->stores->pluck('tree_name', 'id')->toArray()]), $mergeData);
    }

    /**
     * DataTable
     *
     * @param $query
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable($query)
    {
        $user = auth()->user();
        $edit = $user->can('chemical-edit');

        $dt = new EloquentDataTable($query);
        return $dt->editColumn('name', function (Chemical $chemical) {
            return link_to_route('chemical.show', Str::limit($chemical->name, 40, '...'), ['chemical' => $chemical->id]);
        })->editColumn('catalog_id', function (Chemical $chemical) {
            return $chemical->formatBrandLink();
        })->editColumn('store_name', function (Chemical $chemical) {
            return Str::limit($chemical->store_name, 30, '...');

            /*$stores = explode(',', $chemical->store_name);
            $store = str_limit($stores[0], 35, '...');
            if (count($stores) > 1)
                $store .= "<a data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Tooltip on left\">(" . count($stores) .")</a>";

            return $store;*/
        })->editColumn('amount', function (Chemical $chemical) {
            return Helper::unit($chemical->unit, $chemical->amount);
        })->addColumn('action', function ($item) use ($edit) {
            $resource = $this->getResource();
            $html = view('partials.actions.show', ['resource' => $resource, 'entry' => $item, 'pass' => true])->render() . " "
                . view('partials.actions.edit', ['resource' => $resource, 'entry' => $item, 'pass' => $edit])->render() . " ";

            if (!array_diff($this->grouped ? explode(';', $item->store_id) : [$item->store_id], $this->delStores)) {
                $html .= view('partials.actions.delete', $this->grouped ?
                    ['resource' => $resource, 'entry' => $item, 'response' => 'dt', 'pass' => true]
                    : ['resource' => 'chemical-item', 'entry' => $item, 'response' => 'dt', 'key' => 'item_id', 'pass' => true]
                )->render();
            }
            return $html;
        })->with(['search' => $this->request()->input('search')]);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = Chemical::with('brand')->leftJoin('chemical_items', function ($join) {
            $join->on('chemicals.id', '=', 'chemical_items.chemical_id')->where(function ($query) {
                $query->whereIn('chemical_items.store_id', $this->stores->pluck('id'))
                    ->orWhereNull('chemical_items.store_id');
            });
        })->leftJoin('stores', 'chemical_items.store_id', '=', 'stores.id');

        $request = $this->request()->input('search');
        if (!array_key_exists('attrs', $request))
            $request['attrs'] = ['group'];

        foreach ($request as $key => $value) {
            switch ($key) {
                case 'string':
                    $query->OfString($value, ['chemicals.cas', 'chemicals.catalog_id', 'chemicals.name', 'chemicals.iupac_name', 'chemicals.synonym']);
                    break;
                case 'id':
                    $query->OfColumn('chemicals.id', $value);
                    break;
                case 'store':
                    $query->OfColumn('chemical_items.store_id', array_keys($value));
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
                    $query->OfString($value, ['chemicals.chemspider', 'chemicals.pubchem', 'chemicals.formula']);
                    break;
                case 'inchikey':
                    if ($value)
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
