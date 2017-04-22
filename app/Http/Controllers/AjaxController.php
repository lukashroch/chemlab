<?php namespace ChemLab\Http\Controllers;

use ChemLab\Brand;
use ChemLab\Chemical;
use ChemLab\Permission;
use ChemLab\Role;
use ChemLab\Store;
use ChemLab\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;

class AjaxController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
                    $chemData = [];
                    $chemicals = Chemical::select('name', 'iupac_name', 'synonym', 'catalog_id', 'cas')->get();
                    foreach ($chemicals as $chemical) {
                        $chemData['catalogId'][] = $chemical->catalog_id;
                        $chemData['cas'][] = $chemical->cas;
                        $chemData['name'][] = $chemical->name;
                        if (!empty($chemical->iupac_name))
                            $chemData['name'][] = $chemical->iupac_name;
                        if (!empty($chemical->synonym))
                            $chemData['name'] = array_merge($chemData['name'], explode(', ', $chemical->synonym));
                    }

                    $chemData['catalogId'] = $this->array_iunique($chemData['catalogId']);
                    $chemData['cas'] = $this->array_iunique($chemData['cas']);
                    $chemData['name'] = $this->array_iunique($chemData['name']);

                    foreach ($chemData['catalogId'] as $key => $value) {
                        $chemData['all'][] = ['label' => $value, 'category' => 'Catalog ID'];
                    }

                    foreach ($chemData['cas'] as $key => $value) {
                        $chemData['all'][] = ['label' => $value, 'category' => 'CAS'];
                    }

                    foreach ($chemData['name'] as $key => $value) {
                        $chemData['all'][] = ['label' => $value, 'category' => 'Name'];
                    }

                    return array(
                        'catalogId' => array_values($chemData['catalogId']),
                        'cas' => array_values($chemData['cas']),
                        'name' => array_values($chemData['name']),
                        'all' => $chemData['all']
                    );
                });
                break;
            }
            default: {
                $data = [];
                break;
            }
        }

        return response()->json($data);
    }

    private function array_iunique($array)
    {
        return array_intersect_key($array, array_unique(array_map('strtolower', $array)));
    }
}
