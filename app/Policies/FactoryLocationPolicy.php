<?php

namespace App\Policies;

use App\Models\FactoryLocation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class FactoryLocationPolicy
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
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view factory locations.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FactoryLocation  $dutyFreeLocation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, FactoryLocation $dutyFreeLocation)
    {
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view factory locations.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return isAuthorized(FactoryLocation::class, 'create', $user) ? Response::allow() : Response::deny('You are not allowed to create factory location.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FactoryLocation  $dutyFreeLocation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, FactoryLocation $dutyFreeLocation)
    {
        return isAuthorized(FactoryLocation::class, 'edit', $user) ? Response::allow() : Response::deny('You are not allowed to update factory location.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FactoryLocation  $dutyFreeLocation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, FactoryLocation $dutyFreeLocation)
    {
        return isAuthorized(FactoryLocation::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to archive factory location.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FactoryLocation  $dutyFreeLocation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, FactoryLocation $dutyFreeLocation)
    {
        return isAuthorized(FactoryLocation::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to restore factory location.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FactoryLocation  $dutyFreeLocation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, FactoryLocation $dutyFreeLocation)
    {
        return isAuthorized(FactoryLocation::class, 'delete', $user) ? Response::allow() : Response::deny('You are not allowed to delete factory location.');
    }
}
