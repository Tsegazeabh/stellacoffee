<?php

namespace App\Policies;

use App\Models\CuppingProcedure;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class CuppingProcedurePolicy
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
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view cupping procedures.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CuppingProcedure  $cuppingProcedure
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, CuppingProcedure $cuppingProcedure)
    {
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view cupping procedures.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return isAuthorized(CuppingProcedure::class, 'create', $user) ? Response::allow() : Response::deny('You are not allowed to create cupping procedure.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CuppingProcedure  $cuppingProcedure
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, CuppingProcedure $cuppingProcedure)
    {
        return isAuthorized(CuppingProcedure::class, 'edit', $user) ? Response::allow() : Response::deny('You are not allowed to edit cupping procedure.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CuppingProcedure  $cuppingProcedure
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, CuppingProcedure $cuppingProcedure)
    {
        return isAuthorized(CuppingProcedure::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to archive cupping procedure.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CuppingProcedure  $cuppingProcedure
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, CuppingProcedure $cuppingProcedure)
    {
        return isAuthorized(CuppingProcedure::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to restore cupping procedure.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CuppingProcedure  $cuppingProcedure
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, CuppingProcedure $cuppingProcedure)
    {
        return isAuthorized(CuppingProcedure::class, 'delete', $user) ? Response::allow() : Response::deny('You are not allowed to delete cupping procedure.');
    }
}
