<?php

namespace ChemLab\Http\Controllers\Admin;

use ChemLab\Http\Controllers\Controller;
use Ifsnop\Mysqldump as IMysqldump;
use Illuminate\Support\Collection;
use League\Flysystem\Adapter\Ftp as FtpAdapter;
use League\Flysystem\Adapter\Local as LocalAdapter;
use League\Flysystem\Filesystem;
use League\Flysystem\MountManager;
use Prologue\Alerts\Facades\Alert;

class BackupsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:backups-show')->only(['index', 'show', 'download']);
        $this->middleware('permission:backups-create')->only('create');
        $this->middleware('permission:backups-delete')->only('delete');
    }

    /**
     * Display a listing of the resource
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index()
    {
        $aFiles = glob($this->backupPath('*.gz'));

        array_multisort(array_map('filemtime', $aFiles), SORT_NUMERIC, SORT_DESC, $aFiles);

        $files = [];
        for ($i = 0; $i < count($aFiles); $i++) {
            // Keep only last 10 backup files on hosting, delete rest of them
            if ($i < 10) {
                $file = (object)[
                    'id' => basename($aFiles[$i]),
                    'name' => basename($aFiles[$i]),
                    'date' => date("d.m.Y H:i", filemtime($aFiles[$i])),
                    'size' => round(filesize($aFiles[$i]) / 1024, 2),
                    'store' => null, // TODO fix this, dummy as ->store check in delte action is accessing attribute with magic method and this object doesn't have it
                ];
                array_push($files, $file);
            } else
                unlink($this->backupPath(basename($aFiles[$i])));
        }
        $files = new Collection($files);

        return view('admin.backups.index')->with(compact('files'));
    }

    /**
     * Create new resource in storage
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        $name = $this->run();
        Alert::success(trans('backups.message.stored', ['name' => $name]))->flash();
        return redirect(route('backups.index'));
    }

    /**
     * Download specified resource
     *
     * @param $name
     * @return \Illuminate\Http\Response
     */
    public function download($name)
    {
        return response()->download($this->backupPath($name));
    }

    /**
     * Delete specified resource
     *
     * @param string $name
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($name)
    {
        if (file_exists($this->backupPath($name)))
            unlink($this->backupPath($name));

        Alert::success(trans('backups.message.deleted', ['name' => $name]))->flash();
        return response()->json(['type' => 'redirect', 'url' => route('backups.index')]);
    }

    /**
     * Trigger new database backup via cron
     *
     * @param $token
     * @return void
     */
    public function cron($token = null)
    {
        if ($token != config('chemlab.db_backup.secret_key'))
            abort(404);

        $this->run();
    }

    /**
     * Run database backup
     *
     * @return string
     */
    private function run()
    {
        $dbConfig = config()->get('database.connections.mysql');
        $ftpConfig = config()->get('filesystems.disks.ftp');
        $name = $dbConfig['database'] . '-' . date('Ymd-His', time()) . '.gz';

        $dump = new IMysqldump\Mysqldump(
            $dbConfig['driver'] . ':' . 'host=' . $dbConfig['host'] . ';dbname=' . $dbConfig['database'],
            $dbConfig['username'],
            $dbConfig['password'], [
                'compress' => 'Gzip',
                'add-drop-table' => true,
                'extended-insert' => true
            ]
        );
        $dump->start($this->backupPath($name));

        $manager = new MountManager([
                'local' => new Filesystem(new LocalAdapter($this->backupPath())),
                'dropbox' => app('Dropbox'),
                'ftp' => new Filesystem(new FtpAdapter([
                    'host' => $ftpConfig['host'],
                    'username' => $ftpConfig['username'],
                    'password' => $ftpConfig['password'],
                    'root' => $ftpConfig['root']
                ]))
            ]
        );

        if ($manager->has("local://{$name}")) {
            if (!$manager->has("ftp://{$name}"))
                $manager->copy("local://{$name}", "ftp://{$name}");
            if (!$manager->has("dropbox://{$name}"))
                $manager->copy("local://{$name}", "dropbox://{$name}");
        }

        return $name;
    }

    /**
     * Get database backups path
     *
     * @param $path string|null
     * @return string
     */
    private function backupPath($path = null)
    {
        return $path ? storage_path("app/backups/{$path}") : storage_path("app/backups");
    }
}
