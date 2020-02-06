<?php

namespace ChemLab\Http\Controllers\Advanced;

use ChemLab\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class CacheController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:cache-delete')->only('clear');
    }

    /**
     * Clear selected temporary folder files
     *
     * @param string $path
     * @return JsonResponse
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

        return response()->json(['status' => 'success']);
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
