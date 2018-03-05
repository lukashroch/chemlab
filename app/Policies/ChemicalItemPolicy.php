<?php

namespace ChemLab\Policies;

use ChemLab\ChemicalItem;
use ChemLab\Store;
use ChemLab\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChemicalItemPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the chemicalItem.
     *
     * @param  \ChemLab\User $user
     * @param  \ChemLab\ChemicalItem $chemicalItem
     * @return mixed
     */
    public function show(User $user, ChemicalItem $chemicalItem)
    {
        return $user->hasPermission('chemical-show', $chemicalItem->store->team_id);
    }

    /**
     * Determine whether the user can create chemicalItems.
     *
     * @param  \ChemLab\User $user
     * @return mixed
     */
    public function store(User $user)
    {
        $newStore = Store::findOrFail(request()->input('store_id'));
        return $user->hasPermission('chemical-edit', $newStore->team_id);
    }

    /**
     * Determine whether the user can update the chemicalItem.
     *
     * @param  \ChemLab\User $user
     * @param  \ChemLab\ChemicalItem $chemicalItem
     * @return mixed
     */
    public function update(User $user, ChemicalItem $chemicalItem)
    {
        $newStore = Store::findOrFail(request()->input('store_id'));
        return $user->hasPermission('chemical-edit', $chemicalItem->store->team_id) && $user->hasPermission('chemical-edit', $newStore->team_id);
    }

    /**
     * Determine whether the user can delete the chemicalItem.
     *
     * @param  \ChemLab\User $user
     * @param  \ChemLab\ChemicalItem $chemicalItem
     * @return mixed
     */
    public function delete(User $user, ChemicalItem $chemicalItem)
    {
        return $user->hasPermission('chemical-delete', $chemicalItem->store->team_id);
    }
}
