<?php

namespace ChemLab\Policies;

use ChemLab\Models\ChemicalItem;
use ChemLab\Models\Store;
use ChemLab\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChemicalItemPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the chemicalItem.
     *
     * @param User $user
     * @param ChemicalItem $chemicalItem
     * @return mixed
     */
    public function show(User $user, ChemicalItem $chemicalItem)
    {
        return $user->hasPermission('chemicals-show', $chemicalItem->store->team_id);
    }

    /**
     * Determine whether the user can create chemicalItems.
     *
     * @param User $user
     * @return mixed
     */
    public function store(User $user)
    {
        $storeId = request()->input('store_id');
        if (!$storeId)
            return false;

        $store = Store::findOrFail(request()->input('store_id'));
        return $user->hasPermission('chemicals-create', $store->team_id);
    }

    /**
     * Determine whether the user can update the chemicalItem.
     *
     * @param User $user
     * @param ChemicalItem $chemicalItem
     * @return mixed
     */
    public function update(User $user, ChemicalItem $chemicalItem)
    {
        $newStore = Store::findOrFail(request()->input('store_id'));
        return $user->hasPermission('chemicals-edit', $chemicalItem->store->team_id) && $user->hasPermission('chemicals-edit', $newStore->team_id);
    }

    /**
     * Determine whether the user can delete the chemicalItem.
     *
     * @param User $user
     * @param ChemicalItem $chemicalItem
     * @return mixed
     */
    public function delete(User $user, ChemicalItem $chemicalItem)
    {
        return $user->hasPermission('chemicals-delete', $chemicalItem->store->team_id);
    }
}
