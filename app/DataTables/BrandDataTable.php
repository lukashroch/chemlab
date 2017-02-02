<?php

namespace ChemLab\DataTables;

use ChemLab\Brand;

class BrandDataTable extends BaseDataTable
{
    protected function getModule()
    {
        return 'brand';
    }

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        $res = $this->datatables->of($this->query());

        return $this->addActionData($res)->make(true);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = Brand::query();

        if ($this->request()->has('s')) {
            $query->where('name', 'LIKE', "%" . $this->request()->get('s') . "%");
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
                'title' => trans('brand.name')
            ],
            [
                'data' => 'description',
                'name' => 'description',
                'title' => trans('brand.description')
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
        return 'brands_' . time();
    }
}
