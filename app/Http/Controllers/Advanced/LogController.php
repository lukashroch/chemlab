<?php

namespace ChemLab\Http\Controllers\Advanced;

use ChemLab\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class LogController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:logs-show')->only(['index', 'refs', 'show']);
        $this->middleware('permission:logs-delete')->only('delete');
    }

    /**
     * Resource listing
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $aFiles = glob(storage_path('logs/*.log'));

        $files = new Collection();
        for ($i = 0; $i < count($aFiles); $i++) {
            $files->add([
                'id' => pathinfo($aFiles[$i], PATHINFO_FILENAME),
                'name' => basename($aFiles[$i]),
                'date' => filemtime($aFiles[$i]),
                'size' => filesize($aFiles[$i])
            ]);
        }

        $params = request()->input();
        $sorts = $params && array_key_exists('sort', $params) ? explode(',', $params['sort']) : ['name|desc'];
        list($sortCol, $sortDir) = explode('|', $sorts[0]);
        $sorted = $sortDir == 'asc' ? $files->sortBy($sortCol) : $files->sortByDesc($sortCol);

        return response()->json(['data' => $sorted->values()->all(), 'links' => [], 'meta' => []]);
    }

    /**`
     * Reference resource data
     *
     * @return JsonResponse
     */
    public function refs(): JsonResponse
    {
        return response()->json([
            'actions' => [
                'table' => ['show', 'delete'],
                'toolbar' => ['show', 'delete'],
            ]
        ]);
    }

    /**
     * Show specified resource
     *
     * @param $name
     * @return JsonResponse
     */
    public function show($name): JsonResponse
    {
        $content = File::get(storage_path('logs/') . $name . '.log');
        $content = preg_replace('/(\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\] )/', '@;$$;@$1', $content);
        $content = array_reverse(array_filter(explode('@;$$;@', $content)));

        return response()->json(['data' => [
            'name' => $name,
            'content' => $content
        ]]);
    }

    /**
     * Delete specified resource
     *
     * @param string $name
     * @return JsonResponse
     */
    public function delete($name = null): JsonResponse
    {
        $id = request()->input('id');
        $files = (is_array($id) && !empty($id)) ? $id : [$name];

        foreach ($files as $file) {
            $file = basename($file . '.log');
            if (file_exists($this->logPath($file)))
                unlink($this->logPath($file));
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Get database backups path
     *
     * @param $path string|null
     * @return string
     */
    private function logPath($path = null): string
    {
        return $path ? storage_path("logs/{$path}") : storage_path("logs");
    }
}
