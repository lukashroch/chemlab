<?php

namespace ChemLab\Http\Controllers;

use ChemLab\Brand;
use ChemLab\Chemical;
use ChemLab\Permission;
use ChemLab\Role;
use ChemLab\Store;
use ChemLab\User;
use Ifsnop\Mysqldump as IMysqldump;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Adapter\Ftp as FtpAdapter;
use League\Flysystem\Adapter\Local as LocalAdapter;
use League\Flysystem\Filesystem;
use League\Flysystem\MountManager;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin'])->except(['runBackup']);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function overview()
    {
        $count['users'] = User::count();
        $count['roles'] = Role::count();
        $count['permissions'] = Permission::count();
        $count['brands'] = Brand::count();
        $count['stores'] = Store::count();
        $count['chemicals'] = Chemical::count();

        return view('admin.overview')->with(compact('count'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function DBBackup()
    {
        $aFiles = glob(path('dump/*.gz'));
        array_multisort(array_map('filemtime', $aFiles), SORT_NUMERIC, SORT_DESC, $aFiles);

        $files = [];
        for ($i = 0; $i < count($aFiles); $i++) {
            // Keep only last 3 backup files on hosting, delete rest of them
            if ($i < 3) {
                $files[$i] = [
                    'name' => basename($aFiles[$i]),
                    'date' => date("d-m-Y h:i:s", filemtime($aFiles[$i])),
                    'size' => round(filesize($aFiles[$i]) / 1024, 2),
                ];
            } else
                Storage::delete(path('dump/' . basename($aFiles[$i]), true));
        }

        return view('admin.dbbackup')->with(compact('files'));
    }

    /**
     * @param $name
     * @return \Illuminate\Http\Response
     */
    public function DBBackupShow($name)
    {
        return response()->download(path("dump/{$name}"));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */

    public function DBBackupCreate()
    {
        $name = $this->runBackup();
        return redirect(route('admin.dbbackup'))->withFlashMessage(trans('admin.dbbackup.msg.inserted', ['name' => $name]));
    }

    /**
     * @param $name
     * @return \Illuminate\Http\JsonResponse
     */
    public function DBBackupDelete($name)
    {
        Storage::delete(path("dump/{$name}"));
        Session::flash('flash_message', trans('admin.dbbackup.msg.deleted', ['name' => $name]));

        return response()->json(['type' => 'redirect', 'url' => route('admin.dbbackup')]);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function cache()
    {
        $cache = [];

        if (cache()->has('chemical-search'))
            $cache['chemical-search'] = count(cache()->get('chemical-search'));
        if (cache()->has('brand-search'))
            $cache['brand-search'] = count(cache()->get('brand-search'));
        if (cache()->has('store-treeview'))
            $cache['store-treeview'] = count(cache()->get('store-treeview'));
        if (cache()->has('permission-search'))
            $cache['permission-search'] = count(cache()->get('permission-search'));
        if (cache()->has('role-search'))
            $cache['role-search'] = count(cache()->get('role-search'));
        if (cache()->has('user-search'))
            $cache['user-search'] = count(cache()->get('user-search'));

        return view('admin/cache')->with(compact('cache'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cacheClear()
    {
        cache()->flush();
        return redirect('admin/cache')->withFlashMessage(trans('admin.cache.cleared'));
    }

    /**
     * @return string
     */
    public function runBackup()
    {
        $dbConfig = config()->get('database.connections.mysql');
        $ftpConfig = config()->get('filesystems.disks.ftp');
        $name = $dbConfig['database'] . '-' . date('Ymd-His', time()) . '.gz';

        $dump = new IMysqldump\Mysqldump(
            $dbConfig['driver'] . ':' . 'host=' . $dbConfig['host'] . ';dbname=' . $dbConfig['database'],
            $dbConfig['username'],
            $dbConfig['password'],
            [
                'compress' => 'Gzip',
                'add-drop-table' => true,
                'extended-insert' => true
            ]
        );
        $dump->start(path("dump/{$name}"));

        $manager = new MountManager([
                'local' => new Filesystem(new LocalAdapter(path('dump'))),
                'dropbox' => app('Dropbox'),
                'ftp' => new Filesystem(new FtpAdapter([
                    'host' => $ftpConfig['host'],
                    'username' => $ftpConfig['username'],
                    'password' => $ftpConfig['password'],
                    'root' => $ftpConfig['root'],
                ])),
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
}
