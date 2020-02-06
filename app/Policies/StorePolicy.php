<?php

namespace ChemLab\Policies;

use ChemLab\Models\Store;
use ChemLab\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StorePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the store.
     *
     * @param User $user
     * @param Store $store
     * @return mixed
     */
    public function show(User $user, Store $store)
    {
        return $user->can('stores-show', $store->team_id);
    }

    /**
     * Determine whether the user can create stores.
     *
     * @param User $user
     * @return mixed
     */
    public function store(User $user)
    {
        if ($parentId = request()->input('parent_id')) {
            $parentStore = Store::findOrFail($parentId);

            if (!$user->can('stores-create', $parentStore->team_id))
                return false;
        }

        return $user->can('stores-create', request()->input('team_id'));
    }

    /**
     * Determine whether the user can edit the store.
     *
     * @param User $user
     * @param Store $store
     * @return mixed
     */
    public function edit(User $user, Store $store)
    {
        return $user->can('stores-edit', $store->team_id);
    }

    /**
     * Determine whether the user can update the store.
     *
     * @param User $user
     * @param Store $store
     * @return mixed
     */
    public function update(User $user, Store $store)
    {
        if ($newTeam = request()->input('team_id')) {
            if (!$user->can('stores-edit', $newTeam))
                return false;
        }

        if ($parentId = request()->input('parent_id')) {
            $parentStore = Store::findOrFail($parentId);

            if (!$user->can('stores-edit', $parentStore->team_id))
                return false;
        }

        return $user->can('stores-edit', $store->team_id);
    }

    /**
     * Determine whether the user can delete the store.
     *
     * @param User $user
     * @param Store $store
     * @return mixed
     */
    public function delete(User $user, Store $store)
    {
        return $user->can('stores-delete', $store->team_id);
    }
}
