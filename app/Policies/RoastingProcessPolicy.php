<?php

namespace App\Policies;

use App\Models\RoastingProcess;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class RoastingProcessPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view the roasting_process.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\RoastingProcess $roasting_process
     * @return mixed
     */
    public function view(User $user, RoastingProcess $roasting_process)
    {
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view the roasting_process.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return isAuthorized(RoastingProcess::class, 'create', $user) ? Response::allow() : Response::deny('You are not allowed to create a roasting_process.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\RoastingProcess $roasting_process
     * @return mixed
     */
    public function update(User $user, RoastingProcess $roasting_process)
    {
        return isAuthorized(RoastingProcess::class, 'edit', $user) ? Response::allow() : Response::deny('You are not allowed to edit the roasting_process.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\RoastingProcess $roasting_process
     * @return mixed
     */
    public function delete(User $user, RoastingProcess $roasting_process)
    {
        return isAuthorized(RoastingProcess::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to archive the roasting_process.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\RoastingProcess $roasting_process
     * @return mixed
     */
    public function restore(User $user, RoastingProcess $roasting_process)
    {
        return isAuthorized(RoastingProcess::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to restore the roasting_process.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\RoastingProcess $roasting_process
     * @return mixed
     */
    public function forceDelete(User $user, RoastingProcess $roasting_process)
    {
        return isAuthorized(RoastingProcess::class, 'delete', $user) ? Response::allow() : Response::deny('You are not allowed to delete the roasting_process.');
    }
}
