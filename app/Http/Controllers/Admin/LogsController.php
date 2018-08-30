<?php

namespace ChemLab\Http\Controllers\Admin;

use ChemLab\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Prologue\Alerts\Facades\Alert;

class LogsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:logs-show')->only(['index', 'show']);
        $this->middleware('permission:logs-delete')->only('delete');
    }

    /**
     * Display a listing of the resource
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index()
    {
        $aFiles = glob(storage_path('logs/*.log'));

        array_multisort(array_map('filemtime', $aFiles), SORT_NUMERIC, SORT_DESC, $aFiles);

        $files = [];
        for ($i = 0; $i < count($aFiles); $i++) {
            $file = (object)[
                'id' => basename($aFiles[$i]),
                'name' => basename($aFiles[$i]),
                'date' => date("d.m.Y H:i", filemtime($aFiles[$i])),
                'size' => round(filesize($aFiles[$i]) / 1024, 2),
                'store' => null, // TODO fix this, dummy as ->store check in delte action is accessing attribute with magic method and this object doesn't have it
            ];
            array_push($files, $file);
        }
        $files = new Collection($files);

        return view('admin.logs.index')->with(compact('files'));
    }


    /**
     * Show specified resource
     *
     * @param $name
     * @return \Illuminate\Http\Response
     */
    public function show($name)
    {
        $content = File::get(storage_path('logs/') . $name);
        $content = preg_replace('/(\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\] )/', '@;$$;@$1', $content);
        $content = explode('@;$$;@', $content);

        $log = (object)[
            'name' => $name,
            'content' => $content
        ];

        return view('admin.logs.show', compact('log'));
    }

    /**
     * Delete specified resource
     *
     * @param string $name
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($name)
    {
        if (file_exists($this->logPath($name)))
            unlink($this->logPath($name));

        Alert::success(trans('logs.message.deleted', ['name' => $name]))->flash();
        return response()->json(['type' => 'redirect', 'url' => route('logs.index')]);
    }

    /**
     * Get database backups path
     *
     * @param $path string|null
     * @return string
     */
    private function logPath($path = null)
    {
        return $path ? storage_path("logs/{$path}") : storage_path("logs");
    }
}
