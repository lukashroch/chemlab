<?php

namespace ChemLab\Http\Controllers;

use ChemLab\DataTables\TeamDataTable;
use ChemLab\Http\Requests\TeamRequest;
use ChemLab\Team;
use ChemLab\User;

class TeamController extends ResourceController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware(['ajax', 'permission:team-user-detach'])->only('attachUser');
        $this->middleware(['ajax', 'permission:team-user-detach'])->only('detachUser');
    }

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

        return redirect(route('team.edit', ['id' => $team->id]))->withFlashMessage(trans('team.msg.inserted', ['name' => $team->name]));
    }

    /**
     * Display the specified resource.
     *
     * @param Team $team
     * @return \Illuminate\View\View
     */
    public function show(Team $team)
    {
        $team->load('users', 'stores');
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
        $team->load('users');
        $users = User::whereNotIn('id', $team->users->pluck('id'))->orderBy('name')->get();
        return view('team.form', compact('team', 'users'));
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

        return redirect(route('team.index'))->withFlashMessage(trans('team.msg.updated', ['name' => $team->display_name]));
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
            'alert' => ['type' => 'warning', 'text' => trans('team.msg.deleted.disabled')]
        ]);

        //return $this->remove($team);
    }

    /**
     * Attach specified User to selected Team
     *
     * @param Team $team
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function attachUser(Team $team, User $user)
    {
        $team->users()->attach($user);
        return response()->json(['type' => 'success']);
    }

    /**
     * Detach specified User to selected Team
     *
     * @param Team $team
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function detachUser(Team $team, User $user)
    {
        $team->users()->detach($user);
        return response()->json(['type' => 'success']);
    }
}
