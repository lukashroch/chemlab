<?php

namespace ChemLab\Http\Controllers;

use ChemLab\Brand;
use ChemLab\Chemical;
use ChemLab\Helpers\BackupDB;
use ChemLab\Helpers\Helper;
use ChemLab\Permission;
use ChemLab\Role;
use ChemLab\Store;
use ChemLab\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Adapter\Local as LocalAdapter;
use League\Flysystem\Filesystem;
use League\Flysystem\MountManager;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
        $aFiles = glob(Helper::path('dump', true) . '*.zip');
        array_multisort(array_map('filemtime', $aFiles), SORT_NUMERIC, SORT_DESC, $aFiles);
        // TODO
        //$lastBackupTime = round((time() - (!empty($aFiles) ? filemtime($aFiles[0]) : time())) / 86400);

        $files = array();
        for ($i = 0; $i < count($aFiles); $i++) {
            // Keep only last 5 backup files on hosting, delete rest of them
            if ($i < 5) {
                $files[$i] = [
                    'name' => basename($aFiles[$i]),
                    'date' => date("d-m-Y h:i:s", filemtime($aFiles[$i])),
                    'size' => round(filesize($aFiles[$i]) / 1024, 2),
                ];
            } else
                Storage::delete(Helper::path('dump') . (basename($aFiles[$i])));
        }

        return view('admin.dbbackup')->with(compact('files'));
    }

    /**
     * @param $name
     * @return \Illuminate\Http\Response
     */
    public function DBBackupShow($name)
    {
        return response()->download(Helper::path('dump', true) . $name);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function DBBackupCreate()
    {
        $manager = new MountManager([
                'local' => new Filesystem(new LocalAdapter(Helper::path('dump', true))),
                'dropbox' => app('Dropbox')]
        );

        $content = (new BackupDB())->backupTables();
        $name = Config::get('database.connections.mysql.database') . '-' . date('Ymd-His', time());

        if (Helper::zipFile(Helper::path('dump', true), $name, pack("CCC", 0xef, 0xbb, 0xbf) . $content))
            $manager->copy('local://' . $name . '.zip', 'dropbox://' . $name . '.zip');

        return redirect(route('admin.dbbackup'))->withFlashMessage(trans('admin.dbbackup.msg.inserted', ['name' => $name]));
    }

    /**
     * @param $name
     * @return \Illuminate\Http\JsonResponse
     */
    public function DBBackupDelete($name)
    {
        Storage::delete(Helper::path('dump') . $name);
        Session::flash('flash_message', trans('admin.dbbackup.msg.deleted', ['name' => $name]));

        return response()->json(['type' => 'redirect', 'url' => route('admin.dbbackup')]);
    }

    public function webdav()
    {
        $local = new Filesystem(new LocalAdapter(Helper::path('dump', true)));
        $manager = new MountManager(array('local' => $local, 'webdav' => app('WebDAV')));

        $content = (new BackupDB())->backupTables();
        $name = Config::get('database.connections.mysql.database') . '-' . date('Ymd-His', time());

        if (Helper::zipFile(Helper::path('dump', true), $name, pack("CCC", 0xef, 0xbb, 0xbf) . $content))
            $manager->copy('local://' . $name . '.zip', 'webdav://new/' . $name . '.zip');

        return redirect(route('admin.index'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function cache()
    {
        $cache = array();
        if (Cache::tags('chemical')->has('search')) {
            $chemical = Cache::tags('chemical')->get('search');
            $cache['chemical-all'] = count($chemical['all']);
            $cache['chemical-name'] = count($chemical['name']);
            $cache['chemical-cas'] = count($chemical['cas']);
            $cache['chemical-catalogId'] = count($chemical['catalogId']);
        }

        if (Cache::tags('brand')->has('search'))
            $cache['brand-search'] = count(Cache::tags('brand')->get('search'));
        if (Cache::tags('store')->has('treeview'))
            $cache['store-treeview'] = count(Cache::tags('store')->get('treeview'));
        if (Cache::tags('permission')->has('search'))
            $cache['permission-search'] = count(Cache::tags('permission')->get('search'));
        if (Cache::tags('role')->has('search'))
            $cache['role-search'] = count(Cache::tags('role')->get('search'));
        if (Cache::tags('user')->has('search'))
            $cache['user-search'] = count(Cache::tags('user')->get('search'));

        return view('admin/cache')->with(compact('cache'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cacheClear()
    {
        Cache::flush();
        return redirect('admin/cache')->withFlashMessage(trans('admin.cache.cleared'));
    }
}
