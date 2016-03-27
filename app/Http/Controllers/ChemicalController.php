<?php namespace ChemLab\Http\Controllers;

use Carbon\Carbon;
use ChemLab\Brand;
use ChemLab\Chemical;
use ChemLab\ChemicalItem;
use ChemLab\Helpers\ExportPdf;
use ChemLab\Helpers\Listing;
use ChemLab\Http\Requests\ChemicalItemRequest;
use ChemLab\Http\Requests\ChemicalRequest;
use ChemLab\Store;
use Entrust;
use Helper;
use HtmlEx;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class ChemicalController extends ResourceController
{
    public function updatesdf()
    {
        if (!Entrust::hasRole('admin'))
            return redirect(route('home'));

        /*set_time_limit(8000);
        $chemicals = Chemical::skip(1500)->take(1500)->get();
        foreach ($chemicals as $chemical) {
            $data = ['inchikey' => '', 'inchi' => '', 'smiles' => '', 'sdf' => ''];

            if ($chemical->structure->inchikey != '')
                continue;

            if ($chemical->cas != '')
            {
                $content = @file_get_contents("https://cactus.nci.nih.gov/chemical/structure/" . $chemical->cas . "/stdinchikey");
                if ($content === FALSE) {
                    $name = str_replace(' ', '%20', $chemical->name);
                    $name = str_replace('(+)-', '', $name);
                    $name = str_replace('(−)-', '', $name);
                    $name = str_replace('(±)-', '', $name);
                    $content2 = @file_get_contents("https://cactus.nci.nih.gov/chemical/structure/" . $name . "/stdinchikey");
                    if ($content2 === FALSE) {
                        continue;
                    }
                    else {
                        $data['inchikey'] = $content2;
                        $data['inchi'] = file_get_contents("https://cactus.nci.nih.gov/chemical/structure/" . $name . "/stdinchi");
                        $data['smiles'] = file_get_contents("https://cactus.nci.nih.gov/chemical/structure/" . $name . "/smiles");
                        $data['sdf'] = file_get_contents("https://cactus.nci.nih.gov/chemical/structure/" . $name . "/sdf?operator=remove_hydrogens");
                        $chemical->structure()->update($data);
                    }

                } else {
                    $data['inchikey'] = $content;
                    $data['inchi'] = file_get_contents("https://cactus.nci.nih.gov/chemical/structure/" . $chemical->cas . "/stdinchi");
                    $data['smiles'] = file_get_contents("https://cactus.nci.nih.gov/chemical/structure/" . $chemical->cas . "/smiles");
                    $data['sdf'] = file_get_contents("https://cactus.nci.nih.gov/chemical/structure/" . $chemical->cas . "/sdf?operator=remove_hydrogens");
                    $chemical->structure()->update($data);
                }
            }
            else
            {
                $name = str_replace(' ', '%20', $chemical->name);
                $name = str_replace('(+)-', '', $name);
                $name = str_replace('(−)-', '', $name);
                $name = str_replace('(±)-', '', $name);
                $content2 = @file_get_contents("https://cactus.nci.nih.gov/chemical/structure/" . $name . "/stdinchikey");
                if ($content2 === FALSE) {
                    continue;
                }
                else {
                    $data['inchikey'] = $content2;
                    $data['inchi'] = file_get_contents("https://cactus.nci.nih.gov/chemical/structure/" . $name . "/stdinchi");
                    $data['smiles'] = file_get_contents("https://cactus.nci.nih.gov/chemical/structure/" . $name . "/smiles");
                    $data['sdf'] = file_get_contents("https://cactus.nci.nih.gov/chemical/structure/" . $name . "/sdf?operator=remove_hydrogens");
                    $chemical->structure()->update($data);
                }
            }
        }

        $structures = ChemicalStructure::all();
        foreach ($structures as $structure) {
            $structure->update(['inchikey' => str_replace('InChIKey=', '', $structure->inchikey), 'inchi' => str_replace('InChI=', '', $structure->inchi)]);
        }

        foreach ($chemicals as $chemical) {

            if ($chemical->cas == '')
                continue;

            $content = @file_get_contents("https://cactus.nci.nih.gov/chemical/structure/" . $chemical->cas . "/stdinchikey");
            if ($content === FALSE) {
                continue;
            } else {
                $data['inchikey'] = $content;
                $data['inchi'] = file_get_contents("https://cactus.nci.nih.gov/chemical/structure/" . $chemical->cas . "/stdinchi");
                $data['smiles'] = file_get_contents("https://cactus.nci.nih.gov/chemical/structure/" . $chemical->cas . "/smiles");
                $data['sdf'] = file_get_contents("https://cactus.nci.nih.gov/chemical/structure/" . $chemical->cas . "/sdf?operator=remove_hydrogens");
                $chemical->structure()->update($data);
            }
        }*/

        return redirect(route('chemical.index'));
    }

    /**
     * Generate view with store tree
     *
     * @param $route
     * @param array $routeAttr
     * @param array $withAttr
     * @return Response
     */
    private function view($route, $withAttr = array())
    {
        $storeTree = Store::SelectTree();
        return view($route)->with(array_merge($withAttr, compact('storeTree')));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $chemicals = new Listing($this->query('index'), route('chemical.index'));
        $stores = Store::SelectList(array(), true);
        $action = Auth::user()->can(['chemical-edit', 'chemical-delete']);

        return $this->view('chemical.index', compact('chemicals', 'stores', 'action'));
    }

    /**
     * Display a listing of the resource based on selected store.
     *
     * @param $id
     * @return Response
     */
    public function stores($id)
    {
        $store = Store::findOrFail($id);
        $chemicals = new Listing($this->query('stores', $store->getChildrenIdList()), route('chemical.stores', ['store' => $store->id]));
        $action = Auth::user()->can(['chemical-edit', 'chemical-delete']);

        return $this->view('chemical.stores', compact('chemicals', 'store', 'action'));
    }

    /**
     * @return Response
     */
    public function recent()
    {
        $chemicals = $this->query('recent')->paginate(Auth::user()->listing)->appends(Input::All());
        $stores = Store::SelectList();

        return $this->view('chemical.recent', compact('chemicals', 'stores'));
    }

    /**
     * @return Response
     */
    public function search()
    {
        $chemicals = new Listing($this->query('search'), route('chemical.search'));
        $stores = Store::SelectList();
        $action = Auth::user()->can(['chemical-edit', 'chemical-delete']);

        return $this->view('chemical.search', compact('chemicals', 'stores', 'action'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $chemical = new Chemical();
        $brands = [null => trans('common.not.specified')] + Brand::SelectList();

        return $this->view('chemical.form', compact('chemical', 'brands'));
    }

    /**
     * Store a newly created Chemical in storage.
     *
     * @param ChemicalRequest $request
     * @return Response
     */
    public function store(ChemicalRequest $request)
    {
        if ($data = $this->uniqueBrand($request))
            return redirect(route('chemical.create'))->withInput()->withErrors(trans('chemical.brand.error.msg') . link_to_route('chemical.edit', $data->brand_no, ['chemical' => $data->id], ['class' => 'alert-link']));
        else {
            $chemical = Chemical::create($request->except('inchikey', 'inchi', 'smiles', 'sdf'));
            $chemical->structure()->create($request->only('inchikey', 'inchi', 'smiles', 'sdf'));
            return redirect(route('chemical.edit', ['chemical' => $chemical->id]))->withFlashMessage(trans('chemical.msg.inserted', ['name' => $chemical->name]));
        }
    }

    /**
     * Display the specified Chemical.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $chemical = Chemical::findOrFail($id);
        $stores = Store::SelectList(array(), true);
        $action = Auth::user()->can(['chemical-edit', 'chemical-delete']);

        return $this->view('chemical.show', compact('chemical', 'stores', 'action'));
    }

    /**
     * Show the form for editing the specified Chemical.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $chemical = Chemical::structureJoin()->findOrFail($id);
        $brands = [null => trans('common.not.specified')] + Brand::SelectList();
        $stores = Store::SelectList(array(), true);
        $action = Auth::user()->can(['chemical-edit', 'chemical-delete']);

        return $this->view('chemical.form', compact('chemical', 'brands', 'stores', 'action'));
    }

    /**
     * Update the specified Chemical in storage.
     *
     * @param  int $id
     * @param ChemicalRequest $request
     * @return Response
     */
    public function update($id, ChemicalRequest $request)
    {
        if ($data = $this->uniqueBrand($request, $id))
            return redirect(route('chemical.edit', ['chemical' => $id]))->withInput()->withErrors(trans('chemical.brand.error.msg') . link_to_route('chemical.edit', $data->brand_no, ['chemical' => $data->id], ['class' => 'alert-link']));
        else {
            $chemical = Chemical::findOrFail($id);
            $chemical->update($request->except('inchikey', 'inchi', 'smiles', 'sdf'));
            $chemical->structure()->updateOrCreate(['chemical_id' => $id], $request->only('inchikey', 'inchi', 'smiles', 'sdf'));
            return redirect(route('chemical.edit', ['chemical' => $chemical->id]))->withFlashMessage(trans('chemical.msg.updated', ['name' => $chemical->name]));
        }
    }

    /**
     * Remove the specified Chemical from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $chemical = Chemical::findOrFail($id);
        $chemical->structure()->delete();       // TODO delete on cascade
        $chemical->items()->delete();           // TODO delete on cascade

        Session::flash('flash_message', trans('chemical.msg.deleted', ['name' => $chemical->name]));
        $chemical->delete();

        return response()->json(['state' => true, 'url' => route('chemical.index')]);
    }

    /**
     * Store a newly created ChemicalItem in storage.
     *
     * @param ChemicalItemRequest $request
     * @return mixed
     */
    public function itemStore(ChemicalItemRequest $request)
    {
        $chemical = Chemical::findOrFail($request->get('chemical_id'));
        $count = $request->get('count');
        $str = "";

        for ($i = 0; $i < $count; $i++) {
            $item = ChemicalItem::create($request->only('store_id', 'amount', 'unit'));
            $chemical->items()->save($item);
            $str .= view('chemical.partials.item')->with(['item' => $item, 'action' => true])->render();
        }

        return response()->json(['state' => true, 'str' => $str]);
    }

    /**
     * Update the specified ChemicalItem from storage.
     *
     * @param $id
     * @param ChemicalItemRequest $request
     * @return mixed
     */
    public function itemUpdate($id, ChemicalItemRequest $request)
    {
        $item = ChemicalItem::findOrFail($id);
        $item->update($request->only('store_id', 'amount', 'unit'));
        return response()->json(['state' => true, 'str' => view('chemical.partials.item')
            ->with(['item' => $item, 'action' => true])->render()]);
    }

    /**
     * Remove the specified ChemicalItem from storage.
     *
     * @param $id
     * @return mixed
     */
    public function itemDestroy($id)
    {
        $item = ChemicalItem::findOrFail($id);
        $item->delete();

        return response()->json(['state' => true]);
    }

    /**
     * Export the specified Chemicals from storage to PDF file.
     *
     * @param $type
     * @param null|int $store
     * @return mixed
     * @internal param ExportPdf $pdf
     */
    public function export($type, $store = null)
    {
        if ($store)
        {
            $store = Store::findOrFail($store);
            $chemicals = $this->query($type, $store->getChildrenIdList());
        }
        else
            $chemicals = $this->query($type);

        if ($type == 'recent')
            $chemicals = $chemicals->get();

        $header = array(trans('chemical.name'), trans('store.title'), trans('chemical.amount'));

        $data = array();
        foreach ($chemicals as $item) {
            if (empty($item->stores))
                continue;

            $data[] = array(str_limit($item->getDisplayNameWithDesc(), 70), str_limit($item->stores, 35), HtmlEx::unit($item->unit, $item->amount));
        }

        $pdf = new ExportPdf();
        $pdf->formatTable($header, $data);
        return response()->download($pdf->Output('chemicals_export_' . date('d-m-Y') . '.pdf', 'I'), ['content-type' => 'application/pdf']);
    }

    /**
     * Check for uniqueness of Chemical Brand.
     *
     * @param ChemicalRequest $request
     * @param string $id
     * @return mixed
     */
    private function uniqueBrand(ChemicalRequest $request, $id = '')
    {
        $chemical = Chemical::UniqueBrand(['id' => $id, 'brand_id' => $request->input('brand_id'), 'brand_no' => $request->input('brand_no')])->first();
        return count($chemical) ? $chemical : null;
    }

    /**
     * Query Chemicals from storage and return to collection of Chemicals.
     *
     * @param $type
     * @param null $storeId
     * @return mixed
     */
    private function query($type, $storeId = null)
    {
        if ($type == 'index' || $type == 'stores') {
            return Chemical::listSelect()->listJoin()->OfStore($storeId ? $storeId : Input::get('store'))->search(Input::get('search'))
                ->groupBy('chemicals.id')->orderBy('chemicals.name', 'asc')->get();
        } else if ($type == 'search') {
            $search = Helper::searchSession();

            foreach ($search as $key => $value) {
                $search[$key] = Input::get($key, '');
            }

            Session::set('search', $search);

            return Chemical::listSelect()->listJoin()->structureJoin()
                ->where(function ($query) use ($search) {
                    if ($search['name'] != null) {
                        $query->where('chemicals.name', 'LIKE', "%" . $search['name'] . "%");
                        $query->orWhere('chemicals.iupac_name', 'LIKE', "%" . $search['name'] . "%");
                        $query->orWhere('chemicals.synonym', 'LIKE', "%" . $search['name'] . "%");
                    }
                })
                ->where(function ($query) use ($search) {
                    foreach ($search as $key => $value) {
                        if ($key == 'name' || $key == 'sdf' || $key == 'date_operant' || $value == null)
                            continue;

                        if ($key == 'store_id') {
                            $query->OfStore($value);
                        } else if ($key == 'date') {
                            $query->OfDate($value, urldecode($search['date_operant']));
                        } else {
                            $table = $key == 'inchikey' ? 'chemical_structures' : 'chemicals';
                            $query->where($table . '.' . $key, 'LIKE', "%" . $value . "%");
                        }
                    }
                })
                ->groupBy('chemicals.id')->orderBy('chemicals.name', 'asc')->get();
        } else if ($type == 'recent') {
            return Chemical::select('chemicals.id', 'chemicals.name', 'chemicals.description', 'chemical_items.*', 'stores.tree_name as stores')
                ->listJoin()->OfStore(Input::get('store'))->search(Input::get('search'))
                ->recent(Carbon::now()->subDays(30))->latest('chemical_items.created_at');
        }
    }
}
