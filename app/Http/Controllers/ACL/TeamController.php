<?php

namespace ChemLab\Http\Controllers\ACL;

use ChemLab\Http\Controllers\ResourceController;
use ChemLab\Http\Requests\TeamRequest;
use ChemLab\Http\Resources\Team\EntryResource;
use ChemLab\Models\Team;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


class TeamController extends ResourceController
{
    /**
     *
     * @param Team $team
     */
    public function __construct(Team $team)
    {
        parent::__construct($team);
    }

    /**
     * Resource listing
     *
     * @return JsonResource | BinaryFileResponse | View
     */
    public function index(): JsonResource|BinaryFileResponse|View
    {
        return $this->collection(['name', 'display_name']);
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
     * Show the form for creating a new resource
     *
     * @return EntryResource
     */
    public function create(): EntryResource
    {
        return new EntryResource(new Team());
    }

    /**
     * Store a newly created resource in storage
     *
     * @param TeamRequest $request
     * @return EntryResource
     */
    public function store(TeamRequest $request): EntryResource
    {
        $team = new Team();
        $team->name = $request->input('name');
        $team->display_name = $request->input('display_name');
        $team->description = $request->input('description');
        $team->save();

        return new EntryResource($team);
    }

    /**
     * Display the specified resource
     *
     * @param Team $team
     * @return EntryResource
     */
    public function show(Team $team): EntryResource
    {
        return new EntryResource($team);
    }

    /**
     * Show the form for editing the specified resource
     *
     * @param Team $team
     * @return EntryResource
     */
    public function edit(Team $team): EntryResource
    {
        return new EntryResource($team);
    }

    /**
     * Update the specified resource in storage
     *
     * @param Team $team
     * @param TeamRequest $request
     * @return EntryResource
     */
    public function update(Team $team, TeamRequest $request): EntryResource
    {
        $team->update($request->only($team->getFillable()));
        return new EntryResource($team);
    }

    /**
     * Remove the specified resource from storage
     *
     * @param Team $team
     * @return JsonResponse
     * @throws Exception
     */
    public function delete(Team $team = null): JsonResponse
    {
        if ($team->stores->count() > 0)
            return response()->json(['message' => __('teams.msg.has_items', ['name' => $team->name])], 403);

        return $this->triggerDelete($team);
    }
}
