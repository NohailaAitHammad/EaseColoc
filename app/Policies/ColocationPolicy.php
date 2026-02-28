<?php

namespace App\Policies;

use App\Models\Colocation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ColocationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Colocation $colocation): bool
    {
        return $colocation->status === 'active';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Colocation $colocation): bool
    {
        return $colocation->memberships()
            ->where('user_id', $user->id)
            ->where('role', 'owner')
            ->whereNull('left_at')
            ->exists() && $colocation->status === 'active';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Colocation $colocation): bool
    {
        return $colocation->users()
        ->where('user_id', $user->id)
        ->wherePivot('role', 'owner')
        ->exists() && $colocation->status === 'cancelled';
    }

    public function cancel(User $user, Colocation $colocation): bool
    {
        return $colocation->users()
                ->where('user_id', $user->id)
                ->wherePivot('role', 'owner')
                ->exists() &&  $colocation->users()->wherePivot('role', 'membre')->count() === 0;
    }
    //invitation policy
    public function invite(User $user, Colocation $colocation): bool
    {
        return $colocation->users()
                ->where('user_id', $user->id)
                ->wherePivot('role', 'owner')
                ->exists() &&  $colocation->users()->wherePivot('role', 'membre')->count() < $colocation->max_membres
                && $colocation->status === 'active';

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Colocation $colocation): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Colocation $colocation): bool
    {
        return false;
    }
}
