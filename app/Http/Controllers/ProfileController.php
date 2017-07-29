<?php

namespace ChemLab\Http\Controllers;

use ChemLab\Mail\PasswordChanged;
use ChemLab\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ajax')->only('update');
    }

    /**
     * Display authenticated User profile.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = auth()->user();
        $user->load('roles');
        $stores = $user->getManageableStores();

        return view('profile.index', compact('user', 'stores'));
    }

    /**
     * Update user settings
     *
     * @param Request $request
     * @return void
     */
    public function update(Request $request)
    {
        $user = User::findOrFail(auth()->id());
        $key = $request->input('type');
        if (!$key)
            return;

        $value = $request->input('value');
        $user->settings()->set($key, $value);

        switch ($key) {
            case 'lang':
                session()->put('locale', $value);
                break;
            default:
                break;
        }
    }

    /**
     * Show the form for password change for the authenticated User.
     *
     * @return \Illuminate\View\View
     */
    public function password()
    {
        return view('profile.password', ['user' => auth()->user()]);
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

        $this->validate($request, ['password' => 'required|string|min:6|confirmed']);
        $user->password = bcrypt($request->input('password'));
        $user->save();

        Mail::to($user)->send(new PasswordChanged($user->name, request()->ip()));

        return redirect(route('profile.index'))->withFlashMessage(trans('user.password.changed'));
    }
}
