<?php

namespace ChemLab\Policies;

use ChemLab\Store;
use ChemLab\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StorePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the store.
     *
     * @param  \ChemLab\User $user
     * @param  \ChemLab\Store $store
     * @return mixed
     */
    public function show(User $user, Store $store)
    {
        return $user->can('store-show', $store->team_id);
    }

    /**
     * Determine whether the user can create stores.
     *
     * @param  \ChemLab\User $user
     * @return mixed
     */
    public function store(User $user)
    {
        if ($parentId = request()->input('parent_id')) {
            $parentStore = Store::findOrFail($parentId);

            if (!$user->can('store-edit', $parentStore->team_id))
                return false;
        }

        return $user->can('store-edit', request()->input('team_id'));
    }

    /**
     * Determine whether the user can edit the store.
     *
     * @param  \ChemLab\User $user
     * @param  \ChemLab\Store $store
     * @return mixed
     */
    public function edit(User $user, Store $store)
    {
        return $user->can('store-edit', $store->team_id);
    }

    /**
     * Determine whether the user can update the store.
     *
     * @param  \ChemLab\User $user
     * @param  \ChemLab\Store $store
     * @return mixed
     */
    public function update(User $user, Store $store)
    {
        if ($newTeam = request()->input('team_id')) {
            if (!$user->can('store-edit', $newTeam))
                return false;
        }

        if ($parentId = request()->input('parent_id')) {
            $parentStore = Store::findOrFail($parentId);

            if (!$user->can('store-edit', $parentStore->team_id))
                return false;
        }

        return $user->can('store-edit', $store->team_id);
    }

    /**
     * Determine whether the user can delete the store.
     *
     * @param  \ChemLab\User $user
     * @param  \ChemLab\Store $store
     * @return mixed
     */
    public function delete(User $user, Store $store)
    {
        return $user->can('store-delete', $store->team_id);
    }
}
