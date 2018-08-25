<?php

namespace ChemLab\Http\Controllers;

use ChemLab\Brand;
use ChemLab\Chemical;
use ChemLab\DataTables\ChemicalDataTable;
use ChemLab\Helpers\Parser\Parser;
use ChemLab\Http\Requests\ChemicalRequest;
use ChemLab\Store;
use ChemLab\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Prologue\Alerts\Facades\Alert;

class ChemicalController extends ResourceController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('permission:chemical-show')->only('getSDS');
        $this->middleware(['ajax', 'permission:chemical-edit'])->only(['checkBrand', 'parse']);
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
        $manageableStores = auth()->user()->getManageableStoreList();
        $storeTree = Store::selectTree();
        return $dataTable->render('chemical.index', compact('stores', 'manageableStores', 'storeTree'));
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
                's' => $request->input('s', [])
            ];
            $chemical = Chemical::create(array_merge($defaults, $request->except('inchikey', 'inchi', 'smiles', 'sdf')));
            $chemical->structure()->create($request->only('inchikey', 'inchi', 'smiles', 'sdf'));
            if ($file = $request->file('sds')) {
                $ext = $file->guessClientExtension();
                $file->storeAs('sds', "{$chemical->id}.{$ext}");
            }
            Alert::success(trans('chemical.msg.inserted', ['name' => $chemical->name]))->flash();
            return redirect(route('chemical.edit', ['chemical' => $chemical->id]));
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
        $chemical->load('brand', 'structure', 'items', 'items.store', 'items.owner');
        $stores = auth()->user()->getManageableStoreList();
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
        $chemical->load('brand', 'structure', 'items', 'items.store', 'items.owner');
        $brands = Brand::getList();
        $stores = auth()->user()->getManageableStoreList();
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
                'symbol' => $request->input('symbol', null),
                'h' => $request->input('h', null),
                'p' => $request->input('p', null),
                'r' => $request->input('r', null),
                's' => $request->input('s', null)
            ];
            $chemical->update(array_merge($defaults, $request->except('inchikey', 'inchi', 'smiles', 'sdf')));
            $chemical->structure()->updateOrCreate(['chemical_id' => $chemical->id], $request->only('inchikey', 'inchi', 'smiles', 'sdf'));
            if ($file = $request->file('sds')) {
                $ext = $file->guessClientExtension();
                $file->storeAs('sds', "{$chemical->id}.{$ext}");
            }
            Alert::success(trans('chemical.msg.updated', ['name' => $chemical->name]))->flash();
            return redirect(route('chemical.edit', ['chemical' => $chemical->id]));
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
            return response()->download(path("sds/{$chemical->id}.pdf"), $chemical->name . '.pdf');
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
            path('dump/ss.pdf'));

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
        $path = path('dump/test2233.pdf');

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
