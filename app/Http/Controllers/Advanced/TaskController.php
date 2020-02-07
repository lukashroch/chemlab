<?php

namespace ChemLab\Http\Controllers\Advanced;

use ChemLab\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:tasks-show');
        $this->middleware('permission:tasks-cache')->only('cache');
    }

    /**
     * Clear selected temporary folder files
     *
     * @param string $type
     * @return JsonResponse
     */
    public function cache(string $type)
    {
        if (!in_array($type, ['data', 'sessions', 'views']))
            return response()->json(null, 403);

        if ($type == 'data')
            $fullPath = storage_path("framework/cache/{$type}/*");
        else
            $fullPath = storage_path("framework/{$type}/*");

        $files = glob($fullPath);

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
    private function deleteDirectory($dir): bool
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
