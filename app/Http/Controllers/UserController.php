<?php namespace ChemLab\Http\Controllers;

use ChemLab\DataTables\UserDataTable;
use ChemLab\Helpers\Helper;
use ChemLab\Http\Requests\UserRequest;
use ChemLab\Role;
use ChemLab\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Mail;

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

        $data = array('url' => URL::to('/'), 'name' => $user->name, 'email' => $user->email, 'password' => $password);
        \Mail::send('user.emails.new', $data, function ($message) use ($data) {
            $message->to($data['email'], $data['name'])->from(Config::get('mail.from.address'), Config::get('mail.from.name'))->subject('ChemLab: Váš nový účet');
        });
        $user->save();

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
        $user->name = $request->input('name');
        $user->save();

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
     * Display authenticated User profile.
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        $user = Auth::user();
        $user->load('roles');

        return view('user.profile', compact('user'));
    }

    /**
     * Show the form for password change for the authenticated User.
     *
     * @return \Illuminate\View\View
     */
    public function password()
    {
        return view('user.password', ['user' => Auth::user()]);
    }

    /**
     * Update password of of authenticated User in storage.
     *
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function passwordUpdate(Request $request)
    {
        $user = $request->user();

        if (!Auth::attempt(['email' => $user->email, 'password' => $request->input('password_current')]))
            return redirect()->back()->withInput()->withErrors([trans('user.password.current.no.match')]);

        $this->validate($request, ['password' => 'required|confirmed|min:6']);
        $user->password = bcrypt($request->input('password'));
        $user->save();

        return redirect(route('user.profile'))->withFlashMessage(trans('user.password.changed'));
    }

    /**
     * Attach specified Role to selected User
     *
     * @param User $user
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function attachRole(User $user, Role $role)
    {
        if (Auth::user()->canHandleRole($role->name)) {
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
     * Detach specified Role to selected User
     *
     * @param User $user
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function detachRole(User $user, Role $role)
    {
        if (Auth::user()->canHandleRole($role->name)) {
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
