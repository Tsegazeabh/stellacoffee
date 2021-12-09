<?php

namespace App\Policies;

use App\Models\DutyFreeLocation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class DutyFreeLocationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view duty free locations.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DutyFreeLocation  $dutyFreeLocation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, DutyFreeLocation $dutyFreeLocation)
    {
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view duty free locations.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return isAuthorized(DutyFreeLocation::class, 'create', $user) ? Response::allow() : Response::deny('You are not allowed to create duty free location.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DutyFreeLocation  $dutyFreeLocation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, DutyFreeLocation $dutyFreeLocation)
    {
        return isAuthorized(DutyFreeLocation::class, 'edit', $user) ? Response::allow() : Response::deny('You are not allowed to update duty free location.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DutyFreeLocation  $dutyFreeLocation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, DutyFreeLocation $dutyFreeLocation)
    {
        return isAuthorized(DutyFreeLocation::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to archive duty free location.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DutyFreeLocation  $dutyFreeLocation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, DutyFreeLocation $dutyFreeLocation)
    {
        return isAuthorized(DutyFreeLocation::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to restore duty free location.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DutyFreeLocation  $dutyFreeLocation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, DutyFreeLocation $dutyFreeLocation)
    {
        return isAuthorized(DutyFreeLocation::class, 'delete', $user) ? Response::allow() : Response::deny('You are not allowed to delete duty free location.');
    }
}
