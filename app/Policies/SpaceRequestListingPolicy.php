<?php

namespace App\Policies;

use App\Models\SpaceRequestListing;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SpaceRequestListingPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SpaceRequestListing $spaceRequestListing): bool
    {
        return $user->isActive();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isActive(); // && $user->isOnboarded();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SpaceRequestListing $spaceRequestListing): bool
    {
        return $user->isActive() && $user->id == $spaceRequestListing->user_id; // && $user->isOnboarded();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SpaceRequestListing $spaceRequestListing): bool
    {
        return $user->isActive() && $user->id == $spaceRequestListing->user_id; // && $user->isOnboarded();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SpaceRequestListing $spaceRequestListing): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SpaceRequestListing $spaceRequestListing): bool
    {
        return false;
    }
}
