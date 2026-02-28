<?php

namespace App\Policies;

use App\Models\Colocation;
use App\Models\Depense;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DepensePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user, Colocation $colocation): bool
    {
        //$colocation->users()->
        return $colocation->users()->where('user_id', $user->id)->exists();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Depense $depense): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Colocation $colocation): bool
    {
        return $colocation->status === 'active' &&  $colocation->users()->where('user_id', $user->id)->exists();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Depense $depense): bool
    {
        return  $depense->colocation->status === 'active' &&  $depense->is_setled === 0 && $depense->colocation->users()->where('user_id', $user->id)->exists()
            && $depense->payeur->id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Depense $depense): bool
    {
        return $depense->colocation->status === 'active' &&  $depense->is_setled === 0 &&  $depense->colocation->users()->where('user_id', $user->id)->exists()
            && $depense->payeur->id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Depense $depense): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Depense $depense): bool
    {
        return false;
    }
}
