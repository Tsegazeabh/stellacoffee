<?php

namespace App\Policies;

use App\Models\RoastingService;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class RoastingServicePolicy
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
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view the roasting_service.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\RoastingService $roasting_service
     * @return mixed
     */
    public function view(User $user, RoastingService $roasting_service)
    {
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view the roasting_service.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return isAuthorized(RoastingService::class, 'create', $user) ? Response::allow() : Response::deny('You are not allowed to create a roasting_service.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\RoastingService $roasting_service
     * @return mixed
     */
    public function update(User $user, RoastingService $roasting_service)
    {
        return isAuthorized(RoastingService::class, 'edit', $user) ? Response::allow() : Response::deny('You are not allowed to edit the roasting_service.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\RoastingService $roasting_service
     * @return mixed
     */
    public function delete(User $user, RoastingService $roasting_service)
    {
        return isAuthorized(RoastingService::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to archive the roasting_service.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\RoastingService $roasting_service
     * @return mixed
     */
    public function restore(User $user, RoastingService $roasting_service)
    {
        return isAuthorized(RoastingService::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to restore the roasting_service.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\RoastingService $roasting_service
     * @return mixed
     */
    public function forceDelete(User $user, RoastingService $roasting_service)
    {
        return isAuthorized(RoastingService::class, 'delete', $user) ? Response::allow() : Response::deny('You are not allowed to delete the roasting_service.');
    }
}
