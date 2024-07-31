<?php

namespace App\Policies;

use App\Models\Destination;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DestinationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return $user->checkPermissionAccess('list_destination');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionAccess('add_destination');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        return $user->checkPermissionAccess('edit_destination');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return $user->checkPermissionAccess('delete_destination');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Destination $destination): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Destination $destination): bool
    {
        //
    }
}
