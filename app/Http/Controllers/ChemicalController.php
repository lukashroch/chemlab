<?php namespace ChemLab\Http\Controllers;

use Carbon\Carbon;
use ChemLab\Brand;
use ChemLab\Chemical;
use ChemLab\ChemicalItem;
use ChemLab\Department;
use ChemLab\Helpers\ExportPdf;
use ChemLab\Helpers\Listing;
use ChemLab\Http\Requests\ChemicalItemRequest;
use ChemLab\Http\Requests\ChemicalRequest;
use ChemLab\Store;
use Entrust;
use Helper;
use HtmlEx;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $chemicals = new Listing($this->query('index'), route('chemical.index'));
        $stores = Store::SelectDepList();
        $action = Auth::user()->can(['chemical-edit', 'chemical-delete']);

        return view('chemical.index')->with(compact('chemicals', 'stores', 'action'));
    }

    /**
     * @return $this
     */
    public function recent()
    {
        $chemicals = $this->query('recent')->paginate(Auth::user()->listing)->appends(Input::All());
        $stores = Store::SelectDepList();

        return view('chemical.recent')->with(compact('chemicals', 'stores'));
    }

    /**
     * @return $this
     */
    public function search()
    {
        $chemicals = new Listing($this->query('search'), route('chemical.search'));
        $departments = Department::SelectList();
        $department = Input::get('department_id');
        $stores = $department != null ? Store::OfDepartment($department)->SelectDepList() : Store::SelectDepList();
        $action = Auth::user()->can(['chemical-edit', 'chemical-delete']);

        return view('chemical.search')->with(compact('chemicals', 'departments', 'stores', 'action'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $chemical = new Chemical();
        $brands = Brand::SelectList();

        return view('chemical.form')->with(compact('chemical', 'brands'));
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
            return redirect(route('chemical.create'))->withInput()->withErrors(trans('chemical.brand.error.msg') . link_to_route('chemical.edit', $data->brand_no, ['id' => $data->id], ['class' => 'alert-link']));
        else {
            $chemical = Chemical::create($request->except('inchikey', 'inchi', 'smiles', 'sdf'));
            $chemical->structure()->create($request->only('inchikey', 'inchi', 'smiles', 'sdf'));
            return redirect(route('chemical.edit', ['id' => $chemical->id]))->withFlashMessage(trans('chemical.msg.inserted', ['name' => $chemical->name]));
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
        $stores = Store::SelectDepList();
        $action = Auth::user()->can(['chemical-edit', 'chemical-delete']);

        return view('chemical.show')->with(compact('chemical', 'stores', 'action'));
    }

    /**
     * Show the form for editing the specified Chemical.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $chemical = Chemical::select('chemicals.*', 'chemical_structures.*')
            ->join('chemical_structures', 'chemicals.id', '=', 'chemical_structures.chemical_id')
            ->findOrFail($id);
        $brands = [null => trans('common.not.specified')] + Brand::SelectList();
        $stores = Store::SelectDepList();
        $action = Auth::user()->can(['chemical-edit', 'chemical-delete']);

        return view('chemical.form')->with(compact('chemical', 'brands', 'stores', 'action'));
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
            return redirect(route('chemical.edit', ['id' => $id]))->withInput()->withErrors(trans('chemical.brand.error.msg') . link_to_route('chemical.edit', $data->brand_no, ['id' => $data->id], ['class' => 'alert-link']));
        else {
            $chemical = Chemical::findOrFail($id);
            $chemical->update($request->except('inchikey', 'inchi', 'smiles', 'sdf'));
            $chemical->structure()->updateOrCreate(['chemical_id' => $id], $request->only('inchikey', 'inchi', 'smiles', 'sdf'));
            return redirect(route('chemical.edit', ['id' => $chemical->id]))->withFlashMessage(trans('chemical.msg.updated', ['name' => $chemical->name]));
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
     * @param ExportPdf $pdf
     * @return mixed
     */
    public function export($type, ExportPdf $pdf)
    {
        $chemicals = $this->query($type);
        if ($type == 'recent')
            $chemicals = $chemicals->get();

        $header = array(trans('chemical.name'), trans('store.title'), trans('chemical.amount'));

        $data = array();
        foreach ($chemicals as $item) {
            $data[] = array(str_limit($item->getDisplayNameWithDesc(), 70), str_limit($item->stores, 35), HtmlEx::unit($item->unit, $item->amount));
        }

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
     * @return mixed
     */
    private function query($type)
    {
        if ($type == 'index') {
            return Chemical::listSelect()->listJoin()->OfStore(Input::get('store'))->search(Input::get('search'))
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

                        if ($key == 'store_id' || $key == 'department_id') {
                            $table = $key == 'store_id' ? 'chemical_items' : 'stores';
                            $query->where($table . '.' . $key, '=', $value);
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
            return Chemical::select('chemicals.id', 'chemicals.name', 'chemicals.description', 'chemical_items.*',
                DB::raw('CONCAT_WS(" - ", departments.prefix, stores.name) as stores'))
                ->listJoin()->OfStore(Input::get('store'))->search(Input::get('search'))
                ->recent(Carbon::now()->subDays(30))->latest('chemical_items.created_at');
        }
    }
}
