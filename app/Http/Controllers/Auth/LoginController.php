<?php

namespace ChemLab\Http\Controllers\Auth;

use ChemLab\Http\Controllers\Controller;
use ChemLab\Http\Resources\User\ProfileResource;
use ChemLab\Models\Settings;
use ChemLab\Models\User;
use ChemLab\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * The user has been authenticated.
     *
     * @param Request $request
     * @param mixed $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        return new ProfileResource($user);
    }

    /**
     * The user has logged out of the application.
     *
     * @param Request $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        return response()->json(null);
    }

    /**
     * Redirect the user to the provider authentication page.
     *
     * @param string $driver
     * @return RedirectResponse
     */
    public function redirectToProvider($driver)
    {
        return Socialite::driver($driver)->redirect();
    }

    /**
     * Obtain the user information from provider.
     *
     * @param string $driver
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleProviderCallback($driver)
    {
        try {
            $sUser = Socialite::driver($driver)->stateless()->user();
        } catch (\Exception $e) {
            return redirect()->to('/');
        }

        if (!$sUser->email) {
            //Alert::notice(__('common.oauth2.missing_email'))->flash();
            return redirect()->to('/');
        }

        $user = User::where('email', $sUser->email)->first();

        if (!$user) {
            $name = $sUser->name;

            switch ($driver) {
                case 'google';
                    if ($sUser->user) {
                        if (array_key_exists('given_name', $sUser->user) && array_key_exists('family_name', $sUser->user))
                            $name = $sUser->user['given_name'] . ' ' . $sUser->user['family_name'];
                    }
                    break;
                case 'linkedin';
                    if ($sUser->first_name && $sUser->last_name)
                        $name = $sUser->first_name . ' ' . $sUser->last_name;
                    break;
            }

            $user = new User();
            $user->name = $name;
            $user->email = $sUser->email;
            $user->email_verified_at = Carbon::now();
            $user->settings = Settings::defaults();
            $user->save();
        }

        if (!$user->social($driver)->first()) {
            $user->socials()->create(['provider' => $driver, 'provider_id' => $sUser->id]);
        }

        auth()->login($user, true);

        return redirect($this->redirectPath());
    }
}
