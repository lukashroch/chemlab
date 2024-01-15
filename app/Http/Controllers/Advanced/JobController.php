<?php

namespace ChemLab\Http\Controllers\Advanced;

use ChemLab\Jobs\Cron\RunNextQueueJob;
use ChemLab\Jobs\Cron\RunQueue;
use ChemLab\Http\Controllers\ResourceController;
use ChemLab\Http\Resources\Job\EntryResource;
use ChemLab\Models\Job;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class JobController extends ResourceController
{
    /**
     *
     * @param Job $job
     */
    public function __construct(Job $job)
    {
        parent::__construct($job);
        $this->middleware('permission:jobs-execute')->only(['runNextJob', 'runQueue']);
    }

    /**
     * Resource listing
     *
     * @return JsonResource
     */
    public function index(): JsonResource
    {
        return $this->collection(['queue']);
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
     * Display the specified resource
     *
     * @param Job $job
     * @return EntryResource
     */
    public function show(Job $job): EntryResource
    {
        return new EntryResource($job);
    }

    /**
     * Run next job
     *
     * @return JsonResponse
     */
    public function runNextJob(): JsonResponse
    {
        RunNextQueueJob::dispatchSync();
        return response()->json(['status' => 'success']);
    }

    /**
     * Run all jobs
     *
     * @return JsonResponse
     */
    public function runQueue(): JsonResponse
    {
        RunQueue::dispatchSync();
        return response()->json(['status' => 'success']);
    }

    /**
     * Remove the specified resource from storage
     *
     * @param Job $job
     * @return JsonResponse
     * @throws Exception
     */
    public function delete(Job $job): JsonResponse
    {
        return $this->triggerDelete($job);
    }
}
