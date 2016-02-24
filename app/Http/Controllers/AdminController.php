<?php namespace ChemLab\Http\Controllers;

use ChemLab\Brand;
use ChemLab\Chemical;
use ChemLab\Department;
use ChemLab\Helpers\BackupDB;
use ChemLab\Permission;
use ChemLab\Role;
use ChemLab\Store;
use ChemLab\User;
use Dropbox\Client as DropboxClient;
use Helper;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Adapter\Local as LocalAdapter;
use League\Flysystem\Dropbox\DropboxAdapter;
use League\Flysystem\Filesystem;
use League\Flysystem\MountManager;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function overview()
    {
        $count['users'] = User::count();
        $count['roles'] = Role::count();
        $count['permissions'] = Permission::count();
        $count['brands'] = Brand::count();
        $count['departments'] = Department::count();
        $count['stores'] = Store::count();
        $count['chemicals'] = Chemical::count();

        return view('admin.overview')->with(compact('count'));
    }

    public function DBBackup()
    {
        $aFiles = glob(Helper::path('dump', true) . '*.zip');
        array_multisort(array_map('filemtime', $aFiles), SORT_NUMERIC, SORT_DESC, $aFiles);
        // TODO
        $lastBackupTime = round((time() - (!empty($aFiles) ? filemtime($aFiles[0]) : time())) / 86400);

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

    public function DBBackupShow($name)
    {
        return Response::download(Helper::path('dump', true) . $name);
    }

    public function DBBackupCreate()
    {
        $local = new Filesystem(new LocalAdapter(Helper::path('dump', true)));
        $client = new DropboxClient(Config::get('filesystems.disks.dropbox.accessToken'), Config::get('filesystems.disks.dropbox.appName'));
        $dropbox = new Filesystem(new DropboxAdapter($client));
        $manager = new MountManager(array('local' => $local, 'dropbox' => $dropbox));

        $content = (new BackupDB())->backupTables();
        $name = Config::get('database.connections.mysql.database') . '-' . date('Ymd-His', time());

        if (Helper::zipFile(Helper::path('dump', true), $name, pack("CCC", 0xef, 0xbb, 0xbf) . $content))
            $manager->copy('local://' . $name . '.zip', 'dropbox://' . $name . '.zip');

        return redirect(route('admin.dbbackup'))->withFlashMessage(trans('admin.dbbackup.msg.inserted', ['name' => $name]));
    }

    public function DBBackupDelete($name)
    {
        Storage::delete(Helper::path('dump') . $name);
        Session::flash('flash_message', trans('admin.dbbackup.msg.deleted', ['name' => $name]));

        return response()->json([
            'state' => 'deleted',
            'redirect' => route('admin.dbbackup')
        ]);
    }

    public function cache()
    {
        $cache = array();
        if (Cache::has('autocomplete-chemical'))
            $cache['chemical'] = count(Cache::get('autocomplete-chemical'));
        if (Cache::has('autocomplete-chemical-brandid'))
            $cache['chemical-brandid'] = count(Cache::get('autocomplete-chemical-brandid'));
        if (Cache::has('autocomplete-chemical-cas'))
            $cache['chemical-cas'] = count(Cache::get('autocomplete-chemical-cas'));
        if (Cache::has('autocomplete-chemical-name'))
            $cache['chemical-name'] = count(Cache::get('autocomplete-chemical-name'));
        if (Cache::has('autocomplete-department'))
            $cache['department'] = count(Cache::get('autocomplete-department'));
        if (Cache::has('autocomplete-store'))
            $cache['store'] = count(Cache::get('autocomplete-store'));
        if (Cache::has('autocomplete-role'))
            $cache['role'] = count(Cache::get('autocomplete-role'));
        if (Cache::has('autocomplete-user'))
            $cache['user'] = count(Cache::get('autocomplete-user'));

        return view('admin/cache')->with(compact('cache'));
    }

    public function cacheUpdate()
    {
        $data = array();

        $chemicals = Chemical::select('name', 'iupac_name', 'synonym', 'brand_no', 'cas')->get();
        foreach ($chemicals as $chemical) {
            $data['chemical-brandid'][] = $chemical->brand_no;
            $data['chemical-cas'][] = $chemical->cas;
            $data['chemical-name'][] = $chemical->name;
            if (!empty($chemical->iupac_name))
                $data['chemical-name'][] = $chemical->iupac_name;
            if (!empty($chemical->synonym))
                $data['chemical-name'] = array_merge($data['chemical-name'], explode(', ', $chemical->synonym));
        }

        $data['chemical-brandid'] = $this->array_iunique($data['chemical-brandid']);
        $data['chemical-cas'] = $this->array_iunique($data['chemical-cas']);
        $data['chemical-name'] = $this->array_iunique($data['chemical-name']);

        foreach ($data['chemical-brandid'] as $key => $value) {
            $data['chemical'][] = array('label' => $value, 'category' => 'Brand ID');
        }

        foreach ($data['chemical-cas'] as $key => $value) {
            $data['chemical'][] = array('label' => $value, 'category' => 'CAS');
        }

        foreach ($data['chemical-name'] as $key => $value) {
            $data['chemical'][] = array('label' => $value, 'category' => 'Name');
        }

        $departments = Department::select('name', 'prefix')->get();
        foreach ($departments as $department) {
            $data['department'][] = $department->name;
            $data['department'][] = $department->prefix;
        }
        $stores = Store::select('name')->get();
        foreach ($stores as $store) {
            $data['store'][] = $store->name;
        }
        $roles = Role::select('name', 'display_name')->get();
        foreach ($roles as $role) {
            $data['role'][] = $role->name;
            $data['role'][] = $role->display_name;
        }
        $users = User::select('name', 'email')->get();
        foreach ($users as $user) {
            $data['user'][] = $user->name;
            $data['user'][] = $user->email;
        }

        Cache::flush();
        Cache::forever('autocomplete-chemical-brandid', array_values($this->array_iunique($data['chemical-brandid'])));
        Cache::forever('autocomplete-chemical-cas', array_values($this->array_iunique($data['chemical-cas'])));
        Cache::forever('autocomplete-chemical-name', array_values($this->array_iunique($data['chemical-name'])));
        //Cache::forever('autocomplete-chemical', array_values($this->array_iunique(array_merge($data['chemical-brandid'], $data['chemical-cas'], $data['chemical-name']))));
        Cache::forever('autocomplete-chemical', $data['chemical']);
        Cache::forever('autocomplete-user', array_values($data['user']));
        Cache::forever('autocomplete-role', array_values($data['role']));
        Cache::forever('autocomplete-department', array_values($data['department']));
        Cache::forever('autocomplete-store', array_values($data['store']));

        return redirect('admin/cache')->withFlashMessage(trans('admin.cache.updated'));
    }

    private function array_iunique($array)
    {
        return array_intersect_key($array, array_unique(array_map('strtolower', $array)));
    }
}
