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

        $request = $this->request()->input('search');
        if (array_key_exists('string', $request) && !empty($request['string'])) {
            $query->where('name', 'LIKE', "%" . $request['string'] . "%");
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
