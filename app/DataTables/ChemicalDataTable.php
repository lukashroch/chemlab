<?php

namespace ChemLab\DataTables;

use Carbon\Carbon;
use ChemLab\Chemical;
use ChemLab\Helpers\Html;

class ChemicalDataTable extends BaseDataTable
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
        $res = $this->datatables->of($this->query())
            ->rawColumns(['name', 'action'])
            ->editColumn('name', function (Chemical $chemical) {
                return "<a href=\"" . route('chemical.show', ['id' => $chemical->id]) . "\">" . str_limit($chemical->name, 40, '...') . "</a>";
            })
            ->editColumn('catalog_id', function (Chemical $chemical) {
                return $chemical->formatBrandLink();
            })
            ->editColumn('store_name', function (Chemical $chemical) {
                return str_contains($chemical->store_name, ',') ?
                    str_limit($chemical->store_name, 30, '...')
                    : $chemical->store_name;

                /*$stores = explode(',', $chemical->store_name);
                $store = str_limit($stores[0], 35, '...');
                if (count($stores) > 1)
                    $store .= "<a data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Tooltip on left\">(" . count($stores) .")</a>";

                return $store;*/
            })
            ->editColumn('amount', function (Chemical $chemical) {
                return Html::unit($chemical->unit, $chemical->amount);
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
        $query = Chemical::listJoin();

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
                        $query->recent(Carbon::now()->subDays(10));
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
                'title' => trans('chemical.name')
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
                'defaultContent' => '',
                'data'           => 'date',
                'name'           => 'date',
                'title'          => 'date',
                'visible' => false,
                'render'         => null,
                'orderable'      => false,
                'searchable'     => false,
                'exportable'     => false,
                'printable'      => true,
                'footer'         => '',
            ]
        ]);
    }

    /*protected function getParameters()
    {
        return array_merge(parent::getParameters(), [
            'order' => [[sizeof($this->getColumns()) - 1, 'desc']]
        ]);
    }*/


    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'chemicals_' . time();
    }
}
