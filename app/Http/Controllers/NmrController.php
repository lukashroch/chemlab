<?php

namespace ChemLab\Http\Controllers;

use ChemLab\DataTables\NmrDataTable;
use ChemLab\Http\Requests\NmrRequest;
use ChemLab\Nmr;
use ChemLab\User;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class NmrController extends ResourceController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('permission:nmr-show', ['only' => ['download']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param NmrDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(NmrDataTable $dataTable)
    {
        $users = auth()->user()->can('nmr-show-all') ? User::selectList(false) : false;
        return $dataTable->render('nmr.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $nmr = new Nmr();
        $users = User::getList();

        return view('nmr.form', compact('nmr', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param NmrRequest $request
     * @return \Illuminate\View\View
     */
    public function store(NmrRequest $request)
    {
        $file = $request->file('file');
        if ($file && $file->isValid()) {
            $path = $file->store('nmr');

            $nmr = new Nmr();
            $nmr->filename = $path;
            $nmr->content = $this->getZipContent($path);
            $nmr->user_id = $request->input('user_id');
            $nmr->save();

            return redirect(route('nmr.index'))->withFlashMessage(trans('nmr.msg.inserted', ['name' => $nmr->getName()]));
        } else
            return redirect()->back();
    }

    /**
     * * * Download the specified resource.
     *
     * @param Nmr $nmr
     * @return \Illuminate\Http\Response
     */
    public function download(Nmr $nmr)
    {
        if (Storage::disk('local')->exists($nmr->filename))
            return response()->download(storage_path('app/' . $nmr->filename), "NMR-data-{$nmr->created_at->format('Y-m-d')}.zip");
        else
            return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Nmr $nmr
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Nmr $nmr)
    {
        return $this->remove($nmr);
    }

    /**
     * Get content info of uploaded NMR Zip file
     *
     * @param  string $path
     * @return string
     */
    private function getZipContent($path)
    {
        $array = [];

        $zip = new ZipArchive();
        $zip->open(path('app/' . $path));

        for ($i = 0; $i < $zip->numFiles; $i++) {
            $info = $zip->statIndex($i);

            if ($info['crc'] == 0 && strpos(basename($info['name']), '.fid') !== false)
                $array[] = basename($info['name']);
        }
        $zip->close();

        return implode(';', $array);
    }
}
