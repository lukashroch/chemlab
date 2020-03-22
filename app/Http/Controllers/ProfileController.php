<?php

namespace ChemLab\Http\Controllers;

use ChemLab\Http\Requests\PasswordRequest;
use ChemLab\Http\Requests\ProfileRequest;
use ChemLab\Http\Resources\User\ProfileResource;
use ChemLab\Notifications\PasswordChanged;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    /**
     * Display authenticated user profile
     *
     * @return ProfileResource
     */
    public function index(): ProfileResource
    {
        $user = auth()->user()->load('socials');
        return new ProfileResource($user);
    }

    /**
     * Update user settings
     *
     * @param ProfileRequest $request
     * @return ProfileResource
     */
    public function update(ProfileRequest $request): ProfileResource
    {
        $user = auth()->user()->load('socials');

        $key = $request->input('key');
        $value = $request->input('value');
        $user->setSettings($key, $value);

        if ($key == 'lang')
            session()->put('locale', $value);

        return new ProfileResource($user);
    }

    /**
     * Update password of authenticated user
     *
     * @param PasswordRequest $request
     * @return JsonResponse
     */
    public function password(PasswordRequest $request): JsonResponse
    {
        $user = auth()->user();
        $user->password = bcrypt($request->input('password'));
        $user->save();

        $user->notify(new PasswordChanged($request->ip()));

        return response()->json(['status' => 'success']);
    }

    /**
     * Unlink login provider
     *
     * @param string $provider
     * @return JsonResponse
     */
    public function unlinkProvider($provider): JsonResponse
    {
        auth()->user()->social($provider)->delete();
        return response()->json(null, 204);
    }
}
