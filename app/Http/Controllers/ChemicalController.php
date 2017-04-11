<?php namespace ChemLab\Http\Controllers;

use ChemLab\Brand;
use ChemLab\Chemical;
use ChemLab\DataTables\ChemicalDataTable;
use ChemLab\Helpers\Helper;
use ChemLab\Http\Requests\ChemicalRequest;
use ChemLab\Store;
use ChemLab\User;
use Entrust;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ChemicalController extends ResourceController
{
    /**
     * @return mixed
     */
    private function getTreeView()
    {
        return Cache::tags('store')->rememberForever('treeview', function () {
            return Store::selectTree();
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @param ChemicalDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(ChemicalDataTable $dataTable)
    {
        $stores = Store::selectList(array(), true);
        $storeTree = $this->getTreeView();
        return $dataTable->render('chemical.index', compact('stores', 'storeTree'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $chemical = new Chemical();
        $brands = Brand::getList();

        return view('chemical.form', compact('chemical', 'brands'));
    }

    /**
     * Store a newly created Chemical in storage.
     *
     * @param ChemicalRequest $request
     * @return \Illuminate\View\View
     */
    public function store(ChemicalRequest $request)
    {
        if ($data = $this->uniqueBrand($request))
            return redirect(route('chemical.create'))->withInput()->withErrors(trans('chemical.brand.error.msg') . link_to_route('chemical.edit', $data->brand_no, ['chemical' => $data->id], ['class' => 'alert-link']));
        else {
            $defaults = [
                'symbol' => $request->input('symbol', []),
                'h' => $request->input('h', []),
                'p' => $request->input('p', []),
                'r' => $request->input('r', []),
                's' => $request->input('s', []),
                'mw' => $request->has('mw') ? $request->input('mw') : 0
            ];
            $chemical = Chemical::create(array_merge($request->except('inchikey', 'inchi', 'smiles', 'sdf', 'mw'), $defaults));
            $chemical->structure()->create($request->only('inchikey', 'inchi', 'smiles', 'sdf'));
            return redirect(route('chemical.edit', ['chemical' => $chemical->id]))->withFlashMessage(trans('chemical.msg.inserted', ['name' => $chemical->name]));
        }
    }

    /**
     * Display the specified Chemical.
     *
     * @param Chemical $chemical
     * @return \Illuminate\View\View
     */
    public function show(Chemical $chemical)
    {
        $chemical->load('brand', 'structure', 'items.store', 'items.owner');
        $stores = Store::selectList(array(), true);
        $users = User::getList();
        $action = Auth::user()->can(['chemical-edit', 'chemical-delete']);

        return view('chemical.show', compact('chemical', 'stores', 'users', 'action'));
    }

    /**
     * Show the form for editing the specified Chemical.
     *
     * @param Chemical $chemical
     * @return \Illuminate\View\View
     */
    public function edit(Chemical $chemical)
    {
        $chemical->load('brand', 'structure', 'items.store', 'items.owner');
        $brands = Brand::getList();
        $stores = Store::selectList(array(), true);
        $users = User::getList();
        $action = Auth::user()->can(['chemical-edit', 'chemical-delete']);

        return view('chemical.form', compact('chemical', 'brands', 'stores', 'users', 'action'));
    }

    /**
     * Update the specified Chemical in storage.
     *
     * @param Chemical $chemical
     * @param ChemicalRequest $request
     * @return \Illuminate\View\View
     */
    public function update(Chemical $chemical, ChemicalRequest $request)
    {
        if ($data = $this->uniqueBrand($request, $chemical->id))
            return redirect(route('chemical.edit', ['chemical' => $chemical->id]))->withInput()->withErrors(trans('chemical.brand.error.msg') . link_to_route('chemical.edit', $data->brand_no, ['chemical' => $data->id], ['class' => 'alert-link']));
        else {
            $defaults = [
                'symbol' => $request->input('symbol', []),
                'h' => $request->input('h', []),
                'p' => $request->input('p', []),
                'r' => $request->input('r', []),
                's' => $request->input('s', []),
                'mw' => $request->has('mw') ? $request->input('mw') : 0,
            ];
            $chemical->update(array_merge($request->except('inchikey', 'inchi', 'smiles', 'sdf', 'mw'), $defaults));
            $chemical->structure()->updateOrCreate(['chemical_id' => $chemical->id], $request->only('inchikey', 'inchi', 'smiles', 'sdf'));
            return redirect(route('chemical.edit', ['chemical' => $chemical->id]))->withFlashMessage(trans('chemical.msg.updated', ['name' => $chemical->name]));
        }
    }

    /**
     * Remove the specified Chemical from storage.
     *
     * @param  Chemical $chemical
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Chemical $chemical)
    {
        return $this->remove($chemical);
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
        $chemical = Chemical::uniqueBrand(['id' => $id, 'brand_id' => $request->input('brand_id'), 'brand_no' => $request->input('brand_no')])->first();
        return count($chemical) ? $chemical : null;
    }

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

    public function getMsdsData()
    {
        if (!Entrust::hasRole('admin'))
            return redirect(route('home'));

        set_time_limit(8000);
        $brands = Brand::SelectPatternList();
        $chemicals = Chemical::skip(1000)->take(1500)->get();
        foreach ($chemicals as $chemical) {

            if ($chemical->brand_id < 1 || $chemical->brand_id > 4 || empty($chemical->brand_no))
                continue;

            if ($data = Helper::parseAldrichData($chemical->brand_id, $chemical->brand_no, $brands[$chemical->brand_id])) {
                $msds = [
                    'symbol' => $data['symbol'],
                    'signal_word' => $data['signal_word'],
                    'h' => $data['h'],
                    'p' => $data['p']
                ];

                $chemical->update($msds);
            }
        }

        return redirect(route('chemical.index'));
    }

    public function getMsdsFile()
    {
        set_time_limit(24 * 60 * 60);
        $this->downloadFile('http://www.sigmaaldrich.com/MSDS/MSDS/DisplayMSDSPage.do?country=AU&language=en&productNumber=B17905&brand=ALDRICH',
            Helper::path('dump', true) . 'ss.pdf');

        //$content = file_get_contents('http://www.sigmaaldrich.com/MSDS/MSDS/DisplayMSDSPage.do?country=AU&language=en&productNumber=B17905&brand=ALDRICH');

        //file_put_contents(Helper::path('dump', true).'ss.pdf', $content);
        //Storage::put(Helper::path('dump') . 'test.pdf', $content);
        //return response()->view($content, ['content-type' => 'application/pdf']);
        return redirect(route('chemical.index'));
    }

    public function getMSDSFile22()
    {
        //$url = 'http://www.sigmaaldrich.com/MSDS/MSDS/DisplayMSDSPage.do?country=CZ&language=cs&productNumber=H5902&brand=SIGMA';
        $url = 'http://www.sigmaaldrich.com/MSDS/MSDS/PrintMSDSAction.do?name=msdspdf_1608234130924425';
        $path = Helper::path('dump', true) . 'test2233.pdf';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, 'http://www.sigmaaldrich.com/MSDS/MSDS/DisplayMSDSPage.do?country=CZ&language=cs&productNumber=H5902&brand=SIGMA');

        $data = curl_exec($ch);

        curl_close($ch);

        $result = file_put_contents($path, $data);

        if (!$result) {
            dd("error");
        } else {
            dd("success");
        }

        return redirect(route('chemical.index'));
    }

    private function downloadFile($url, $path)
    {
        $newfname = $path;
        $file = fopen($url, 'rb');
        if ($file) {
            $newf = fopen($newfname, 'wb');
            if ($newf) {
                while (!feof($file)) {
                    fwrite($newf, fread($file, 1024 * 8), 1024 * 8);
                }
            }
        }
        if ($file) {
            fclose($file);
        }
        if ($newf) {
            fclose($newf);
        }
    }
}
