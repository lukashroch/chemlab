<?php

namespace ChemLab\Http\Controllers\ACL;

use ChemLab\Http\Controllers\ResourceController;
use ChemLab\Http\Requests\UserRequest;
use ChemLab\Http\Resources\User\EntryResource;
use ChemLab\Models\Role;
use ChemLab\Models\Settings;
use ChemLab\Models\User;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class UserController extends ResourceController
{
    /**
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    /**
     * Resource listing
     *
     * @return JsonResource | BinaryFileResponse
     */
    public function index()
    {
        return $this->collection(['name', 'email']);
    }

    /**
     * Reference resource data
     *
     * @return JsonResponse
     */
    public function refs(): JsonResponse
    {
        return $this->refData([
            'filter' => [
                'role' => Role::select('id', 'display_name as name')->orderBy('display_name')->get()->prepend(['id' => 0, 'name' => __('roles.none')])
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource
     *
     * @return EntryResource
     */
    public function create(): EntryResource
    {
        return new EntryResource(new User());
    }

    /**
     * Store a newly created resource in storage
     *
     * @param UserRequest $request
     * @return EntryResource
     */
    public function store(UserRequest $request): EntryResource
    {
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt(Str::random(10));
        $user->settings = Settings::defaults();
        $user->save();

        foreach ($request->input('roles') as $team => $roles) {
            $user->syncRoles($roles, $team == 'global' ? null : $team);
        }

        $user->sendNewPasswordNotification(Password::getRepository()->create($user));
        event(new Registered($user));

        return new EntryResource($user->load('roles'));
    }

    /**
     * Display the specified resource
     *
     * @param User $user
     * @return EntryResource
     */
    public function show(User $user): EntryResource
    {
        return new EntryResource($user->load('roles'));
    }

    /**
     * Show the form for editing the specified resource
     *
     * @param User $user
     * @return EntryResource
     */
    public function edit(User $user): EntryResource
    {
        return new EntryResource($user->load('roles'));
    }

    /**
     * Update the specified resource in storage
     *
     * @param User $user
     * @param UserRequest $request
     * @return EntryResource
     */
    public function update(User $user, UserRequest $request)
    {
        $user->update($request->only('name'));
        $user->roles()->sync([]);

        foreach ($request->input('roles') as $team => $roles) {
            $user->syncRolesWithoutDetaching($roles, $team == 'global' ? null : $team);
        }

        return new EntryResource($user->load('roles'));
    }

    /**
     * Remove the specified resource from storage
     *
     * @param User $user
     * @return JsonResponse
     * @throws Exception
     */
    public function delete(User $user = null): JsonResponse
    {
        return $this->triggerDelete($user);
    }
}
