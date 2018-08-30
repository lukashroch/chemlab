<?php

namespace ChemLab\Http\Controllers;

use ChemLab\DataTables\UserDataTable;
use ChemLab\Helpers\Helper;
use ChemLab\Http\Requests\UserRequest;
use ChemLab\Mail\UserCreated;
use ChemLab\Role;
use ChemLab\Settings;
use ChemLab\Team;
use ChemLab\User;
use Illuminate\Support\Facades\Mail;
use Prologue\Alerts\Facades\Alert;

class UserController extends ResourceController
{
    /**
     * Display a listing of the resource.
     *
     * @param UserDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(UserDataTable $dataTable)
    {
        $roles = Role::SelectList(false, 'display_name') + [0 => trans('role.none')];
        return $dataTable->render('user.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('user.form', ['user' => new User()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return \Illuminate\View\View
     */
    public function store(UserRequest $request)
    {
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $password = Helper::generateKey();
        $user->password = bcrypt($password);
        $user->settings = Settings::defaults();
        $user->save();

        foreach ($request->input('roles') as $team => $roles) {
            $user->syncRoles($roles, $team);
        }

        Mail::to($user)->send(new UserCreated([
            'userName' => $user->name,
            'userPass' => $password,
            'creatorName' => auth()->user()->name]));

        Alert::success(trans('user.msg.inserted', ['name' => $user->name]))->flash();
        return redirect(route('user.edit', ['id' => $user->id]));
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\View\View
     */
    public function show(User $user)
    {
        $user->load('roles');
        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        $user->load('roles');
        $roles = Role::orderBy('name')->get();
        $teams = Team::orderBy('display_name')->get();

        $team = new Team();
        $team->id = 0;
        $teams->put(null, $team);

        foreach ($teams as $team) {
            $team['roles'] = $roles;
        }

        return view('user.form', compact('user', 'teams'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param User $user
     * @param UserRequest $request
     * @return \Illuminate\View\View
     */
    public function update(User $user, UserRequest $request)
    {
        $user->update(['name' => $request->input('name')]);
        $user->roles()->sync([]);
        $teamRoles = $request->input('roles');
        ksort($teamRoles);
        foreach ($teamRoles as $team => $roles) {
            $user->syncRolesWithoutDetaching($roles, $team == 0 ? null : $team);
        }

        Alert::success(trans('user.msg.updated', ['name' => $user->name]))->flash();
        return redirect(route('user.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        return $this->remove($user);
    }
}
