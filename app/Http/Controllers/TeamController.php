<?php

namespace ChemLab\Http\Controllers;

use ChemLab\DataTables\TeamDataTable;
use ChemLab\Http\Requests\TeamRequest;
use ChemLab\Team;
use Prologue\Alerts\Facades\Alert;

class TeamController extends ResourceController
{
    /**
     * Display a listing of the resource.
     *
     * @param TeamDataTable $table
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(TeamDataTable $table)
    {
        return $table->render('team.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('team.form', ['team' => new Team()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TeamRequest $request
     * @return \Illuminate\View\View
     */
    public function store(TeamRequest $request)
    {
        $team = new Team();
        $team->name = $request->input('name');
        $team->display_name = $request->input('display_name');
        $team->description = $request->input('description');
        $team->save();

        Alert::success(trans('team.msg.inserted', ['name' => $team->display_name]))->flash();
        return redirect(route('team.edit', ['id' => $team->id]));
    }

    /**
     * Display the specified resource.
     *
     * @param Team $team
     * @return \Illuminate\View\View
     */
    public function show(Team $team)
    {
        $team->load('stores');
        return view('team.show', compact('team'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Team $team
     * @return \Illuminate\View\View
     */
    public function edit(Team $team)
    {
        return view('team.form', compact('team'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Team $team
     * @param TeamRequest $request
     * @return \Illuminate\View\View
     */
    public function update(Team $team, TeamRequest $request)
    {
        $team->update($request->all());

        Alert::success(trans('team.msg.updated', ['name' => $team->display_name]))->flash();
        return redirect(route('team.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Team $team
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Team $team)
    {
        return response()->json([
            'type' => 'error',
            'message' => ['type' => 'notice', 'text' => trans('team.msg.deleted.disabled')]
        ]);

        //return $this->remove($team);
    }
}
