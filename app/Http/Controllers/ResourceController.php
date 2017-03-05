<?php namespace ChemLab\Http\Controllers;

use ChemLab\Chemical;
use ChemLab\ChemicalItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ResourceController extends Controller
{
    protected $model;

    protected $module;

    public function __construct()
    {
        $this->model = str_replace('Controller', '', class_basename(static::class));
        $this->module = strtolower(str_replace('Item', '', $this->model));

        $this->middleware('auth');
        $this->middleware('permission:' . $this->module . '-show', ['only' => ['index', 'show']]);
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
        $request = request();
        $ids = $request->input('ids');
        $type = $request->input('response');

        if ($ids && is_array($ids) && empty($ids)) {
            $table = Str::snake(Str::plural($this->model));
            if ($table == 'chemical_items') {
                $items = ChemicalItem::where('id', $ids);
                foreach ($items as $item) {
                    $chemical = $item->chemical();
                    $item->delete();

                    if (!$chemical->hasItems())
                        $chemical->delete();
                }
            } else
                DB::table($table)->whereIn('id', $ids)->delete();
            // TODO: cascade this
            /*if ($table == 'chemicals') {
                DB::table('chemical_items')->whereIn('chemical_id', $ids)->delete();
                DB::table('chemical_structures')->whereIn('chemical_id', $ids)->delete();
            }*/
            // Delete orphaned chemical entries
            /*if ($table == 'chemical_items')
            {
                $entries = ChemicalItem::pluck('chemical_id')->unique();
                DB::table('chemicals')->whereNotIn('id', $entries)->delete();
                DB::table('chemical_structures')->whereNotIn('chemical_id', $entries)->delete();
            }*/

            $response = [
                'type' => 'dt',
                'alert' => ['type' => 'success', 'text' => trans('common.msg.multi.deleted')]
            ];
        } else if ($resource && $resource instanceof Model) {
            if ($resource instanceof ChemicalItem)
                $response = ['type' => 'chemical-item'];
            else if ($type == 'redirect') {
                $response = [
                    'type' => $type,
                    'url' => route($this->module . '.index')
                ];
                $request->session()->flash('flash_message', trans($this->module . '.msg.deleted', ['name' => $resource->name]));
            } else {
                $response = [
                    'type' => $type,
                    'alert' => ['type' => 'success', 'text' => trans($this->module . '.msg.deleted', ['name' => $resource->name])]
                ];
            }
            // TODO: cascade this
            if ($resource instanceof Chemical) {
                $resource->structure()->delete();
                $resource->items()->delete();
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
