<?php

namespace ChemLab\Http\Controllers\Advanced;

use ChemLab\Http\Controllers\ResourceController;
use ChemLab\Models\Audit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class AuditController extends ResourceController
{
    /**
     *
     * @param Audit $audit
     */
    public function __construct(Audit $audit)
    {
        parent::__construct($audit);
    }

    /**
     * Resource listing
     *
     * @return JsonResource
     */
    public function index(): JsonResource
    {
        return $this->collection(['auditable_type'], $query = Audit::query());
    }

    /**
     * Reference resource data
     *
     * @return JsonResponse
     */
    public function refs(): JsonResponse
    {
        return $this->refData();
    }

    /**
     * Create new resource in storage
     *
     * @param Audit $audit
     * @return JsonResponse
     */
    public function show(Audit $audit): JsonResponse
    {
        return response()->json($audit);
    }
}
