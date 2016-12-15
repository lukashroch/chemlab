<?php namespace ChemLab\Http\Controllers;

use ChemLab\Brand;
use ChemLab\Chemical;
use ChemLab\Permission;
use ChemLab\Role;
use ChemLab\Store;
use ChemLab\User;
use Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class AjaxController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function attachRole()
    {
        $user = User::findOrFail(Input::get('id'));
        $role = Role::findOrFail(Input::get('role'));

        if (Auth::user()->canHandleRole($role->name))
            $user->attachRole($role);
        else
            return response()->json(array('false'));
    }

    public function detachRole()
    {
        $user = User::findOrFail(Input::get('id'));
        $role = Role::findOrFail(Input::get('role'));

        if (Auth::user()->canHandleRole($role->name))
            $user->detachRole($role);
        else
            return response()->json(array('false'));
    }

    public function attachPermission()
    {
        $role = Role::findOrFail(Input::get('id'));
        $perm = Permission::findOrFail(Input::get('perm'));

        if (Auth::user()->canHandlePermission($perm->name))
            $role->attachPermission($perm);
        else
            return response()->json(array('false'));
    }

    public function detachPermission()
    {
        $role = Role::findOrFail(Input::get('id'));
        $perm = Permission::findOrFail(Input::get('perm'));

        if (Auth::user()->canHandlePermission($perm->name, $role->name))
            $role->detachPermission($perm);
        else
            return response()->json(array('false'));
    }

    public function userSettings()
    {
        if ($user = User::findOrFail(Auth::user()->id)) {
            if (Input::get('type') == 'listing')
                $user->listing = Input::get('value');
            else if (Input::get('type') == 'lang') {
                $user->lang = Input::get('value');
                Session::put('locale', Input::get('value'));
            }

            $user->save();
        }
    }

    /**
     * @return mixed
     */
    public function sdf()
    {
        $action = Input::get('action');
        if (!isset($action))
            return response()->json(array('invalid data'));

        switch ($action) {
            case 'cache-load':
                return response()->json(Helper::searchSession());
            case 'cache-save':
                $data = Helper::searchSession();
                $data['sdf'] = Input::get('sdf');
                Session::set('search', $data);
                return response()->json(array('trans' => trans(Input::get('trans'))));
            case 'cache-reset':
                Session::forget('search');
                return response()->json(array('trans' => trans(Input::get('trans'))));
            default:
                break;
        }
    }

    public function parseSAData()
    {
        $brands = Brand::SelectPatternList();

        foreach ($brands as $key => $value) {
            if ($data = Helper::parseAldrichData($key, Input::get('brand_no'), $value))
                return response()->json($data);
        }
        return response()->json(array('state' => 0));
    }

    public function fillAutoComplete()
    {
        $type = Input::get('type');

        switch ($type) {
            case 'brand': {
                $data['all'] = Cache::tags($type)->rememberForever('search', function () {
                    return Brand::select('name')->orderBy('name')->pluck('name')->toArray();
                });
                break;
            }
            case 'store': {
                $data['all'] = Cache::tags($type)->rememberForever('search', function () {
                    return Store::select('name')->orderBy('name')->pluck('name')->toArray();
                });
                break;
            }
            case 'permission': {
                $data['all'] = Cache::tags($type)->rememberForever('search', function () {
                    return Permission::select('display_name')->orderBy('display_name')->pluck('display_name')->toArray();
                });
                break;
            }
            case 'role': {
                $data['all'] = Cache::tags($type)->rememberForever('search', function () {
                    return Role::select('display_name')->orderBy('display_name')->pluck('display_name')->toArray();
                });
                break;
            }
            case 'user': {
                $data['all'] = Cache::tags($type)->rememberForever('search', function () {
                    return array_flatten(User::select('name', 'email')->get()->toArray());
                });
                break;
            }
            case 'chemical': {
                $data = Cache::tags($type)->rememberForever('search', function () {
                    $chemData = array();
                    $chemicals = Chemical::select('name', 'iupac_name', 'synonym', 'brand_no', 'cas')->get();
                    foreach ($chemicals as $chemical) {
                        $chemData['brandId'][] = $chemical->brand_no;
                        $chemData['cas'][] = $chemical->cas;
                        $chemData['name'][] = $chemical->name;
                        if (!empty($chemical->iupac_name))
                            $chemData['name'][] = $chemical->iupac_name;
                        if (!empty($chemical->synonym))
                            $chemData['name'] = array_merge($chemData['name'], explode(', ', $chemical->synonym));
                    }

                    $chemData['brandId'] = $this->array_iunique($chemData['brandId']);
                    $chemData['cas'] = $this->array_iunique($chemData['cas']);
                    $chemData['name'] = $this->array_iunique($chemData['name']);

                    foreach ($chemData['brandId'] as $key => $value) {
                        $chemData['all'][] = array('label' => $value, 'category' => 'Brand ID');
                    }

                    foreach ($chemData['cas'] as $key => $value) {
                        $chemData['all'][] = array('label' => $value, 'category' => 'CAS');
                    }

                    foreach ($chemData['name'] as $key => $value) {
                        $chemData['all'][] = array('label' => $value, 'category' => 'Name');
                    }

                    return array(
                        'brandId' => array_values($chemData['brandId']),
                        'cas' => array_values($chemData['cas']),
                        'name' => array_values($chemData['name']),
                        'all' => $chemData['all']
                    );
                });
                break;
            }
            default: {
                $data = array();
                break;
            }
        }

        return response()->json($data);
    }

    private function array_iunique($array)
    {
        return array_intersect_key($array, array_unique(array_map('strtolower', $array)));
    }

    public function checkBrand()
    {
        $chemical = Chemical::UniqueBrand(['id' => Input::get('id'), 'brand_id' => Input::get('brand_id'), 'brand_no' => Input::get('brand_no')])->first();

        $data = count($chemical) ? trans('chemical.brand.error.msg')
            . link_to_route('chemical.edit', $chemical->brand_no, ['id' => $chemical->id], ['class' => 'alert-link']) : "valid";

        return response()->json(array($data));
    }

    public function translate()
    {
        return response()->json(array(trans(Input::get('idx'))));
    }
}
