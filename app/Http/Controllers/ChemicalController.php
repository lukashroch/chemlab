<?php

namespace ChemLab\Http\Controllers;

use ChemLab\Brand;
use ChemLab\Chemical;
use ChemLab\DataTables\ChemicalDataTable;
use ChemLab\Helpers\Helper;
use ChemLab\Helpers\Parser;
use ChemLab\Http\Requests\ChemicalRequest;
use ChemLab\Store;
use ChemLab\User;
use Entrust;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChemicalController extends ResourceController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('permission:chemical-show')->only('getSDS');
        $this->middleware(['ajax', 'permission:chemical-edit'])->only(['checkBrand', 'parse']);
    }

    /**
     * @return mixed
     */
    private function getTreeView()
    {
        return cache()->rememberForever('store-treeview', function () {
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
        $stores = Store::selectList([], true);
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
        if ($entry = $this->uniqueBrand($request->input('brand_id'), $request->input('catalog_id')))
            return redirect(route('chemical.create'))->withInput()->withErrors(trans('chemical.brand.error.msg') . link_to_route('chemical.edit', $entry->catalog_id, ['chemical' => $entry->id], ['class' => 'alert-link']));
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
            if ($file = $request->file('sds')) {
                $ext = $file->guessClientExtension();
                $file->storeAs('sds', "{$chemical->id}.{$ext}");
            }
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
        $stores = Store::selectList([], true);
        $users = User::getList();

        return view('chemical.show', compact('chemical', 'stores', 'users'));
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
        $stores = Store::selectList([], true);
        $users = User::getList();

        return view('chemical.form', compact('chemical', 'brands', 'stores', 'users'));
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
        if ($entry = $this->uniqueBrand($request->input('brand_id'), $request->input('catalog_id'), $chemical->id))
            return redirect(route('chemical.edit', ['chemical' => $chemical->id]))->withInput()->withErrors(trans('chemical.brand.error.msg') . link_to_route('chemical.edit', $entry->catalog_id, ['chemical' => $entry->id], ['class' => 'alert-link']));
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
            if ($file = $request->file('sds')) {
                $ext = $file->guessClientExtension();
                $file->storeAs('sds', "{$chemical->id}.{$ext}");
            }
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
     * Download SDS File
     *
     * @param  Chemical $chemical
     * @return \Illuminate\Http\Response
     */
    public function getSDS(Chemical $chemical)
    {
        if (Storage::disk('local')->exists("sds/{$chemical->id}.pdf"))
            return response()->download(storage_path("app/sds/{$chemical->id}.pdf"), $chemical->name . '.pdf');
        else
            return back();
    }

    /**
     * Check brand towards database entries to prevent duplications
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkBrand(Request $request)
    {
        $chemical = $this->uniqueBrand($request->input('brand_id'), $request->input('catalog_id'), $request->input('except'));

        $data['msg'] = $chemical ? trans('chemical.brand.error.msg')
            . link_to_route('chemical.edit', $chemical->catalog_id, ['id' => $chemical->id], ['class' => 'alert-link']) : 'valid';

        return response()->json($data);
    }

    /**
     * Parse chemical data from Sigma Aldrich
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function parse(Request $request)
    {
        $callback = $request->input('callback');
        $brands = Brand::where('parse_callback', 'LIKE', $callback)->orderBy('id', 'asc')->pluck('url_product', 'id')->toArray();

        $parser = new Parser($request->input('catalog_id'), $callback, $brands);

        return response()->json($parser->get());
    }

    public function test2()
    {
        $chemicals = Chemical::get();

        foreach ($chemicals as $chemical) {
            if (strpos($chemical->iupac_name, chr(10))) {
                $chemical->iupac_name = str_replace(chr(10), ';', $chemical->iupac_name);
            }
            if (strpos($chemical->synonym, ', ')) {
                $chemical->synonym = str_replace(', ', ';', $chemical->synonym);

            }
            $chemical->save();
        }
        dd('done');
    }

    public function test()
    {
        $startTime = microtime(true);
        $chemData = [
            'catalogId' => [],
            'cas' => [],
            'name' => [],
        ];
        $chemicals = Chemical::select('name', 'iupac_name', 'synonym', 'catalog_id', 'cas')->get();

        foreach ($chemicals as $chemical) {
            $chemData['catalogId'][] = $chemical->catalog_id;

            if (strpos($chemical->cas, ';'))
                $chemData['cas'] = array_merge($chemData['cas'], explode(';', $chemical->cas));
            else
                $chemData['cas'][] = $chemical->cas;

            $chemData['name'][] = $chemical->name;

            if (strpos($chemical->iupac_name, ';'))
                $chemData['name'] = array_merge($chemData['name'], explode(';', $chemical->iupac_name));
            else
                $chemData['name'][] = $chemical->iupac_name;

            if (strpos($chemical->synonym, ';'))
                $chemData['name'] = array_merge($chemData['name'], explode(';', $chemical->synonym));
            else
                $chemData['name'][] = $chemical->synonym;
        }

        $data = array_merge($chemData['catalogId'], $chemData['cas'], $chemData['name']);
        $data = array_values(array_intersect_key($data, array_unique(array_map('strtolower', $data))));
        array_push($data, microtime(true) - $startTime);

        dd($data);


        $brands = Brand::where('parse_callback', 'LIKE', 'sigma-aldrich')->orderBy('id', 'asc')->pluck('url_product', 'id')->toArray();
        $parser = new Parser('R1706', 'sigma-aldrich', $brands);
        dd($parser->get());

        return response()->json($parser->get());
    }

    /**
     * Check for uniqueness of Chemical Brand.
     *
     * @param string $brandId
     * @param string $brandNo
     * @param string $expect
     * @return Chemical|null
     */
    private function uniqueBrand($brandId, $brandNo, $expect = '')
    {
        $chemical = Chemical::uniqueBrand($brandId, $brandNo, $expect)->first();
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

        /*set_time_limit(8000);
        $brands = Brand::SelectPatternList();
        $chemicals = Chemical::skip(1000)->take(1500)->get();
        foreach ($chemicals as $chemical) {

            if ($chemical->brand_id < 1 || $chemical->brand_id > 4 || empty($chemical->catalog_id))
                continue;

            if ($data = Helper::parseAldrichData($chemical->brand_id, $chemical->catalog_id, $brands[$chemical->brand_id])) {
                $msds = [
                    'symbol' => $data['symbol'],
                    'signal_word' => $data['signal_word'],
                    'h' => $data['h'],
                    'p' => $data['p']
                ];

                $chemical->update($msds);
            }
        }*/

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
