<?php namespace ChemLab\Http\Controllers;

use ChemLab\ChemicalItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ResourceController extends Controller
{
    protected $module;

    public function __construct()
    {
        $this->module = strtolower(str_replace('Item', '', str_replace('Controller', '', class_basename(static::class))));

        $this->middleware('auth');
        $this->middleware('permission:' . $this->module . '-show', ['only' => ['index', 'show', 'recent', 'search']]);
        $this->middleware('permission:' . $this->module . '-edit', ['only' => ['create', 'store', 'edit', 'update']]);
        $this->middleware(['ajax', 'permission:' . $this->module . '-delete'], ['only' => ['delete', 'destroy']]);
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param $resource
     * @return \Illuminate\Http\JsonResponse
     */
    protected function remove($resource)
    {
        $items = request()->get('ids');
        $type = request()->get('response');

        if ($items && is_array($items)) {
            DB::table($this->module . 's')->whereIn('id', $items)->delete();

            $response = [
                'type' => 'dt',
                'alert' => ['type' => 'success', 'text' => trans('common.msg.multi.deleted')]
            ];
        } else if ($resource && $resource instanceof Model) {
            if ($resource instanceof ChemicalItem)
                $response = ['type' => 'chemical-item'];
            else if ($type == 'redirect')
            {
                $response = [
                    'type' => $type,
                    'url' => route($this->module.'.index')
                    //'alert' => ['type' => 'success', 'text' => trans($this->module . '.msg.deleted', ['name' => $resource->name])]
                ];
                request()->session()->flash('flash_message', trans($this->module . '.msg.deleted', ['name' => $resource->name]));
            }
            else {
                $response = [
                    'type' => $type,
                    'alert' => ['type' => 'success', 'text' => trans($this->module . '.msg.deleted', ['name' => $resource->name])]
                ];
            }

            $resource->delete();
        } else {
            $response = [
                'type' => 'error',
                'alert' => ['type' => 'danger', 'text' => trans('common.error')]
            ];
        }
        return response()->json($response);
    }
}
