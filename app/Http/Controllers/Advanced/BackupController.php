<?php

namespace ChemLab\Http\Controllers\Advanced;

use ChemLab\Jobs\Cron\DBBackup;
use ChemLab\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


class BackupController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:backups-show')->only(['index', 'refs', 'download']);
        $this->middleware('permission:backups-create')->only('run');
        $this->middleware('permission:backups-delete')->only('delete');
    }

    /**
     * API call for resource listing
     *
     * @return JsonResponse
     */
    protected function index(): JsonResponse
    {
        $aFiles = glob($this->backupPath('*.gz'));

        $files = new Collection();
        for ($i = 0; $i < count($aFiles); $i++) {
            $files->add([
                'id' => basename($aFiles[$i]),
                'name' => basename($aFiles[$i]),
                'date' => filemtime($aFiles[$i]),
                'size' => filesize($aFiles[$i])
            ]);
        }

        $params = request()->get('params');
        $sorts = $params && array_key_exists('sort', $params) ? explode(',', $params['sort']) : ['name|desc'];
        list($sortCol, $sortDir) = explode('|', $sorts[0]);
        $sorted = $sortDir == 'asc' ? $files->sortBy($sortCol) : $files->sortByDesc($sortCol);

        return response()->json([
            'data' => $sorted->values()->all(),
            'links' => [],
            'meta' => ['per_page' => count($aFiles), 'total' => count($aFiles)]
        ]);
    }

    /**
     * Reference resource data
     *
     * @return JsonResponse
     */
    public function refs(): JsonResponse
    {
        return response()->json([
            'actions' => [
                'table' => ['download', 'delete'],
                'toolbar' => ['run', 'delete'],
            ]
        ]);
    }

    /**
     * Create new database backup
     *
     * @return JsonResponse
     */
    public function run(): JsonResponse
    {
        DBBackup::dispatchSync();
        return response()->json(['status' => 'success'], 201);
    }

    /**
     * Download database backup
     *
     * @param $name
     * @return BinaryFileResponse
     */
    public function download($name): BinaryFileResponse
    {
        return response()->download($this->backupPath(basename($name)));
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
            $file = basename($file);
            if (file_exists($this->backupPath($file)))
                unlink($this->backupPath($file));
        }

        return response()->json(null, 204);
    }

    /**
     * Get database backups path
     *
     * @param $path string|null
     * @return string
     */
    private function backupPath($path = null): string
    {
        return $path ? storage_path("app/backups/{$path}") : storage_path("app/backups");
    }
}
