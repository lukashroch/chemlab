<?php

namespace ChemLab\Http\Controllers;

use ChemLab\Export\Exportable;
use ChemLab\Http\Requests\RestoreRequest;
use ChemLab\Models\Chemical;
use ChemLab\Models\ChemicalItem;
use ChemLab\Models\Traits\ActionableTrait;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

abstract class ResourceController extends Controller
{
    /**
     * Resource name
     *
     * @var string
     */
    protected $resource;

    /**
     * List resource classname
     *
     * @var string
     */
    protected $listResource;

    /**
     * List resource classname
     *
     * @var string
     */
    protected $entryResource;

    /**
     * Model class name of the resource
     *
     * @var object
     */
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->resource = Str::plural(Str::kebab(class_basename($this->model)));
        $this->listResource = 'ChemLab\\Http\\Resources\\' . class_basename($this->model) . '\\ListResource';
        $this->entryResource = 'ChemLab\\Http\\Resources\\' . class_basename($this->model) . '\\EntryResource';

        $this->middleware('permission:' . $this->resource . '-show')->only(['index', 'refs', 'show']);
        $this->middleware('permission:' . $this->resource . '-create')->only(['create', 'store']);
        $this->middleware('permission:' . $this->resource . '-edit')->only(['edit', 'update']);
        $this->middleware('permission:' . $this->resource . '-delete')->only('delete');
        $this->middleware('permission:' . $this->resource . '-audit')->only('audit');
    }

    /**
     * Resource Audit
     *
     * @param int $id
     * @return JsonResource
     */
    public function audit($id): JsonResource
    {
        $entry = $this->model::findOrFail($id);
        return new $this->entryResource($entry);
    }

    /**
     * Reference resource data
     *
     * @param $data array
     * @return JsonResponse
     */
    protected function refData($data = []): JsonResponse
    {
        $appendData = array_merge([
            'actions' => in_array(ActionableTrait::class, class_uses_recursive($this->model)) ? $this->model::actions('index') : [],
            'columns' => $this->model instanceof Exportable ? $this->model::exportColumns() : [],
            'typeahead' => method_exists($this->model, 'autocomplete') ? $this->model->autocomplete() : []
        ], $data);

        return response()->json($appendData);
    }

    /**
     * Resource listing
     *
     * @param $columns array
     * @param $params array
     * @param $query
     * @return JsonResource | BinaryFileResponse
     */
    protected function collection(array $columns = ['name'], $query = null, array $params = [])
    {
        $columns = array_map(function ($item) {
            return str_replace('-', '_', $this->resource) . '.' . $item;
        }, $columns);

        $query = $query ?? $this->model::query();
        $params = array_merge(request()->only(['id', 'text', 'sort', 'page', 'per_page', 'export_format', 'export_columns']), $params);
        $table = $this->model->getTable();

        if (is_array($params) && !empty($params)) {
            foreach ($params as $key => $value) {
                switch ($key) {
                    case 'id':
                        $query->ofColumn($table . '.' . $key, $value);
                        break;
                    case 'text':
                        $query->ofString($value, $columns);
                        break;
                    case 'role':
                        $query->hasRoles($value);
                        break;
                    case 'store':
                        $query->OfColumn('chemical_items.store_id', $value);
                        break;
                    case 'group':
                        if ($value == 'true')
                            $query->groupSelect();
                        else
                            $query->nonGroupSelect();
                        break;
                    case 'recent':
                        if ($value == 'true')
                            $query->recent(Carbon::now()->subDays(30));
                        break;
                    case 'chemspider':
                    case 'pubchem':
                    case 'formula':
                        // TODO fix no table names
                        $query->OfString($value, ['chemicals.chemspider', 'chemicals.pubchem', 'chemicals.formula']);
                        break;
                    case 'inchikey':
                        if ($value)
                            $query->structureJoin()->where('chemical_structures.' . $key, 'LIKE', "%" . $value . "%");
                        break;
                    case 'sort':
                        if ($value) {
                            $sorts = explode(',', $value);
                            foreach ($sorts as $sort) {
                                list($sortCol, $sortDir) = explode('|', $sort);
                                $query->orderBy($sortCol, $sortDir);
                            }
                        } else {
                            $query->orderBy('created_at', 'desc');
                        }
                        break;
                }
            }

            // Export
            if (Arr::has($params, ['export_format', 'export_columns'])) {
                $data = $this->listResource::collection($query->get())->collection->map->export()->all();
                return $this->model::export($params['export_columns'])->mapData($data)->{$params['export_format']}();
            }
        }

        $pagination = $query->paginate(
            filter_var($params['per_page'], FILTER_VALIDATE_INT) !== false ? (int)$params['per_page'] : null,
            ['*'],
            'page',
            $params['page']
        );
        $pagination->appends($params);

        return $this->listResource::collection($pagination);
    }

    /**
     * Remove the specified resources from storage
     *
     * @param object $resource
     * @return JsonResponse
     * @throws Exception
     */
    protected function triggerDelete($resource): JsonResponse
    {
        $id = request()->input('id', []);

        if ($id && is_array($id) && !empty($id)) {
            if ($this->model instanceof Chemical) {
                $stores = ChemicalItem::whereIn('chemical_id', $id)->pluck('store_id')->toArray();
                if (!auth()->user()->canManageStore($stores, 'chemicals-delete')) {
                    return response()->json([
                        'success' => false,
                        'error' => __('chemical-item.store.error')
                    ], 403);
                }

            }

            $this->model::destroy($id);
            return response()->json(null, 204);
        } else if ($resource->id && $resource instanceof $this->model) {
            if ($resource instanceof Chemical) {
                $stores = $resource->items()->pluck('store_id')->toArray();
                if (!auth()->user()->canManageStore($stores, 'chemicals-delete')) {
                    return response()->json([
                        'success' => false,
                        'error' => __('chemical-item.store.error')
                    ], 403);
                }
            }

            $resource->delete();
            return response()->json(null, 204);
        } else {
            return response()->json([
                'success' => false,
                'error' => __('common.error')
            ], 403);
        }
    }

    /**
     * Restore the specified resources
     *
     * @param $request
     * @return JsonResponse
     */
    protected function restore(RestoreRequest $request): JsonResponse
    {
        $items = $this->model::withTrashed()->whereIn('id', $request->input('id'));

        // TODO: $items->restore() doesn't fire restored event, iterate over and restore for now
        foreach ($items->get() as $item) {
            $item->restore();
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Destroy permanently the specified resources
     *
     * @param object $entry
     * @return JsonResponse
     */
    protected function triggerDestroy($entry): JsonResponse
    {
        $entry->forceDelete();
        return response()->json(null, 204);
    }
}
