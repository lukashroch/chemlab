<?php

namespace ChemLab\Http\Controllers;

use ChemLab\DataTables\UserDataTable;
use ChemLab\Helpers\Helper;
use ChemLab\Http\Requests\UserRequest;
use ChemLab\Mail\UserCreated;
use ChemLab\Role;
use ChemLab\Settings;
use ChemLab\User;
use Illuminate\Support\Facades\Mail;

class UserController extends ResourceController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware(['ajax', 'permission:user-edit'])->only(['attachRole', 'detachRole']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param UserDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(UserDataTable $dataTable)
    {
        return $dataTable->render('user.index');
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
        Mail::to($user)->send(new UserCreated([
            'userName' => $user->name,
            'userPass' => $password,
            'creatorName' => auth()->user()->name]));

        return redirect(route('user.edit', ['id' => $user->id]))->withFlashMessage(trans('user.msg.inserted', ['name' => $user->name]));
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
        $roles = Role::whereNotIn('id', $user->roles->pluck('id'))->orderBy('name')->get();

        return view('user.form', compact('user', 'roles'));
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

        return redirect(route('user.index'))->withFlashMessage(trans('user.msg.updated', ['name' => $user->name]));
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

    /**
     * Attach specified Role to selected user
     *
     * @param User $user
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function attachRole(User $user, Role $role)
    {
        if (auth()->user()->canHandleRole($role->name)) {
            $user->attachRole($role);
            return response()->json(['type' => 'success']);
        } else {
            return response()->json([
                'type' => 'error',
                'alert' => ['type' => 'danger', 'text' => trans('common.error')]
            ]);
        }
    }

    /**
     * Detach specified Role from selected user
     *
     * @param User $user
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function detachRole(User $user, Role $role)
    {
        if (auth()->user()->canHandleRole($role->name)) {
            $user->detachRole($role);
            return response()->json(['type' => 'success']);
        } else {
            return response()->json([
                'type' => 'error',
                'alert' => ['type' => 'danger', 'text' => trans('common.error')]
            ]);
        }
    }
}
