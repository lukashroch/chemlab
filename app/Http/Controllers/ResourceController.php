<?php

namespace ChemLab\Http\Controllers;

use ChemLab\ChemicalItem;
use Illuminate\Database\Eloquent\Model;

class ResourceController extends Controller
{
    protected $model;

    protected $module;

    public function __construct()
    {
        $this->model = str_replace('Controller', '', class_basename(static::class));
        $this->module = strtolower(str_replace('Item', '', $this->model));

        $this->middleware('auth');
        $this->middleware('permission:' . $this->module . '-show')->only(['index', 'show']);
        $this->middleware('permission:' . $this->module . '-edit')->only(['create', 'store', 'edit', 'update']);
        $this->middleware(['ajax', 'permission:' . $this->module . '-delete'])->only(['delete', 'destroy']);
        $this->middleware('ajax')->only('autocomplete');
    }

    public function autocomplete()
    {
        if (!request()->input('type'))
            return response()->json(false);

        $class = '\\ChemLab\\' . ucfirst(request()->input('type'));
        if (method_exists($class, 'autocomplete') && is_callable([$class, 'autocomplete']))
            return response()->json(call_user_func([$class, 'autocomplete']));
        else
            return response()->json(false);
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param $resource
     * @return \Illuminate\Http\JsonResponse
     */
    protected function remove($resource)
    {
        $request = request();
        $ids = $request->input('ids');
        $type = $request->input('response');

        if ($ids && is_array($ids) && !empty($ids)) {
            $class = '\\ChemLab\\' . class_basename($resource);

            if (class_basename($resource) == "ChemicalItem") {
                $items = $class::whereIn('id', $ids)->get();
                foreach ($items as $item) {
                    $chemical = $item->chemical;
                    $item->delete();

                    if (!$chemical->hasItems()) {
                        $chemical->delete();
                    }
                }
            } else {
                $class::destroy($ids);
            }

            $response = [
                'type' => 'dt',
                'alert' => ['type' => 'success', 'text' => trans('common.msg.multi.deleted')]
            ];
        } else if ($resource->id && $resource instanceof Model) {
            if ($resource instanceof ChemicalItem) {
                $chemical = $resource->chemical;
                $name = $chemical->name;

                $resource->delete();

                // TODO: cascade structure on chemical, move hasItem check to model (deleting event?)
                if (!$chemical->hasItems() && $type != 'chemical-item') {
                    $chemical->structure->delete();
                    $chemical->delete();
                }
            } else {
                $name = $resource->name or '';
                $resource->delete();
            }


            if ($type == 'redirect') {
                $response = [
                    'type' => $type,
                    'url' => route($this->module . '.index')
                ];
                $request->session()->flash('flash_message', trans($this->module . '.msg.deleted', ['name' => $name]));
            } else {
                $response = [
                    'type' => $type,
                    'alert' => ['type' => 'success', 'text' => trans($this->module . '.msg.deleted', ['name' => $name])]
                ];
            }
        } else {
            $response = [
                'type' => 'error',
                'alert' => ['type' => 'danger', 'text' => trans('common.error')]
            ];
        }
        return response()->json($response);
    }
}
