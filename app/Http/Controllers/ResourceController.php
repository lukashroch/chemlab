<?php

namespace ChemLab\Http\Controllers;

use ChemLab\Chemical;
use ChemLab\ChemicalItem;
use Illuminate\Database\Eloquent\Model;
use Prologue\Alerts\Facades\Alert;

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
            if (class_basename($resource) == 'Chemical') {
                $stores = ChemicalItem::whereIn('chemical_id', $ids)->pluck('store_id')->toArray();
                if (!auth()->user()->canManageStore($stores))
                    return responseJsonError(['error' => [trans('chemical-item.store.error')]]);
            }
            $class::destroy($ids);

            return response()->json([
                'type' => 'dt',
                'message' => ['type' => 'success', 'text' => trans('common.msg.multi.deleted')]
            ]);
        } else if ($resource->id && $resource instanceof Model) {
            if ($resource instanceof Chemical) {
                $stores = $resource->items()->pluck('store_id')->toArray();
                if (!auth()->user()->canManageStore($stores))
                    return responseJsonError(['error' => [trans('chemical-item.store.error')]]);
            }
            $name = $resource->name or '';
            $resource->delete();

            if ($type == 'redirect') {
                Alert::success(trans($this->module . '.msg.deleted', ['name' => $name]))->flash();
                return response()->json([
                    'type' => $type,
                    'url' => route($this->module . '.index')
                ]);
            } else {
                return response()->json([
                    'type' => $type,
                    'message' => ['type' => 'success', 'text' => trans($this->module . '.msg.deleted', ['name' => $name])]
                ]);
            }
        } else {
            return responseJsonError(['error' => [trans('common.error')]]);
        }
    }
}
