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
        $this->middleware(['auth', 'role:admin']);
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
}
