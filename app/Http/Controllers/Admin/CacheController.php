<?php

namespace ChemLab\Http\Controllers\Admin;

use ChemLab\Http\Controllers\Controller;
use Prologue\Alerts\Facades\Alert;

class CacheController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:cache-show')->only('index');
        $this->middleware('permission:cache-delete')->only('clear');
    }

    /**
     * Display cache index page
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.cache.index');
    }

    /**
     * Clear selected temporary folder files
     *
     * @param string $path
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clear($path)
    {
        if (!in_array($path, ['cache', 'sessions', 'views']))
            abort(403);

        $files = glob(storage_path("framework/{$path}/*"));

        foreach ($files as $file) {
            if (is_file($file))
                unlink($file);
            else if (is_dir($file))
                $this->deleteDirectory($file);
        }

        Alert::success(__('cache.message.cleared', ['path' => $path]))->flash();
        return redirect(route('cache.index'));
    }

    /**
     * Recursively delete content of the directory
     *
     * @param string $dir
     * @return boolean
     */
    private function deleteDirectory($dir)
    {
        if (!file_exists($dir)) {
            return true;
        }

        if (!is_dir($dir)) {
            return unlink($dir);
        }

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            if (!$this->deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }

        return rmdir($dir);
    }
}

