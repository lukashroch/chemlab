<?php namespace ChemLab\Http\Controllers;

use ChemLab\Brand;
use ChemLab\Chemical;
use ChemLab\ChemicalItem;
use ChemLab\Permission;
use ChemLab\Role;
use ChemLab\Store;
use ChemLab\User;
use Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class AjaxController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->middleware('auth');
        $this->user = Auth::user();
    }

    public function attachRole()
    {
        $user = User::findOrFail(Input::get('id'));
        $role = Role::findOrFail(Input::get('role'));

        if ($this->user->canHandleRole($role->name))
            $user->attachRole($role);
        else
            return response()->json(array('false'));
    }

    public function detachRole()
    {
        $user = User::findOrFail(Input::get('id'));
        $role = Role::findOrFail(Input::get('role'));

        if ($this->user->canHandleRole($role->name))
            $user->detachRole($role);
        else
            return response()->json(array('false'));
    }

    public function attachPermission()
    {
        $role = Role::findOrFail(Input::get('id'));
        $perm = Permission::findOrFail(Input::get('perm'));

        if ($this->user->canHandlePermission($perm->name))
            $role->attachPermission($perm);
        else
            return response()->json(array('false'));
    }

    public function detachPermission()
    {
        $role = Role::findOrFail(Input::get('id'));
        $perm = Permission::findOrFail(Input::get('perm'));

        if ($this->user->canHandlePermission($perm->name, $role->name))
            $role->detachPermission($perm);
        else
            return response()->json(array('false'));
    }

    public function userSettings()
    {
        if ($user = User::findOrFail($this->user->id)) {
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

    public function updateStoreList()
    {
        $department = Input::get('department');
        $stores = $department != null ? Store::OfDepartment($department)->SelectDepList() : Store::SelectDepList();

        $string = "<option value=\"\">" . trans('chemical.store.all') . "</option>";
        foreach ($stores as $key => $value) {
            $string .= "<option value=\"" . $key . "\">" . $value . "</option>";
        }

        return response()->json($string);
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
        return response()->json(Cache::get('autocomplete-' . Input::get('type')));
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
