<?php

namespace ChemLab\Http\Controllers;

use ChemLab\Http\Requests\PasswordRequest;
use Illuminate\Http\Request;
use Prologue\Alerts\Facades\Alert;

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
        $user->load('teams', 'roles');

        return view('profile.index', compact('user'));
    }

    /**
     * Update user settings
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        $key = $request->input('key');
        if (!$key) {
            return response()->json([
                'status' => 'error',
                'message' => [
                    'type' => 'error',
                    'text' => trans('common.error')
                ]
            ], 403);
        }

        $value = $request->input('value');
        $user->settings()->set($key, $value);

        switch ($key) {
            case 'lang':
                session()->put('locale', $value);
                break;
            default:
                break;
        }

        return response()->json([
            'status' => 'ok',
            'message' => [
                'type' => 'success',
                'text' => trans('profile.settings.saved'),
                'key' => $key,
                'value' => $value
            ]
        ]);
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
     * @param \ChemLab\Http\Requests\PasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function passwordUpdate(PasswordRequest $request)
    {
        $user = auth()->user();
        $user->password = bcrypt($request->input('password'));
        $user->save();

        //Mail::to($user)->later(Carbon::now()->addSeconds(30), new PasswordChanged($user->name, request()->ip()));
        Alert::success(trans('user.password.changed'))->flash();
        return redirect(route('profile.index'));
    }
}
