<?php

namespace App\Policies;

use App\Models\SpaceBookingRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SpaceBookingRequestPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isActive() && $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SpaceBookingRequest $spaceBookingRequest): bool
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
    public function update(User $user, SpaceBookingRequest $spaceBookingRequest): bool
    {
        return $user->isActive() && $user->id == $spaceBookingRequest->user_id; // && $user->isOnboarded();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SpaceBookingRequest $spaceBookingRequest): bool
    {
        return $user->isActive() && $user->id == $spaceBookingRequest->user_id; // && $user->isOnboarded();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SpaceBookingRequest $spaceBookingRequest): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SpaceBookingRequest $spaceBookingRequest): bool
    {
        return false;
    }
}
