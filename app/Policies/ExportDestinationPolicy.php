<?php

namespace App\Policies;

use App\Models\ExportDestination;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class ExportDestinationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view export destination.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\ExportDestination $exportDestination
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ExportDestination $exportDestination)
    {
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view export destination.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return isAuthorized(ExportDestination::class, 'create', $user) ? Response::allow() : Response::deny('You are not allowed to create export destination.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\ExportDestination $exportDestination
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ExportDestination $exportDestination)
    {
        return isAuthorized(ExportDestination::class, 'edit', $user) ? Response::allow() : Response::deny('You are not allowed to update export destination.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\ExportDestination $exportDestination
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ExportDestination $exportDestination)
    {
        return isAuthorized(ExportDestination::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to archive export destination.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\ExportDestination $exportDestination
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, ExportDestination $exportDestination)
    {
        return isAuthorized(ExportDestination::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to restore export destination.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\ExportDestination $exportDestination
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, ExportDestination $exportDestination)
    {
        return isAuthorized(ExportDestination::class, 'delete', $user) ? Response::allow() : Response::deny('You are not allowed to delete export destination.');
    }
}
