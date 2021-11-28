<?php

namespace App\Policies;

use App\Models\Store;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class StorePolicy
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
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view stores.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Store  $salesLocation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Store $salesLocation)
    {
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view store.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return isAuthorized(Store::class, 'edit', $user) ? Response::allow() : Response::deny('You are not allowed to create store.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Store  $salesLocation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Store $salesLocation)
    {
        return isAuthorized(Store::class, 'edit', $user) ? Response::allow() : Response::deny('You are not allowed to update store.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Store  $salesLocation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Store $salesLocation)
    {
        return isAuthorized(Store::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to archive store.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Store  $salesLocation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Store $salesLocation)
    {
        return isAuthorized(Store::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to restore store.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Store  $salesLocation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Store $salesLocation)
    {
        return isAuthorized(Store::class, 'delete', $user) ? Response::allow() : Response::deny('You are not allowed to delete store.');
    }
}
