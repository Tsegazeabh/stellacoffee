<?php

namespace App\Policies;

use App\Models\Cafe;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class CafePolicy
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
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view the cafe_service.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Cafe $cafe_service
     * @return mixed
     */
    public function view(User $user, Cafe $cafe_service)
    {
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view the cafe_service.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return isAuthorized(Cafe::class, 'create', $user) ? Response::allow() : Response::deny('You are not allowed to create a cafe_service.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Cafe $cafe_service
     * @return mixed
     */
    public function update(User $user, Cafe $cafe_service)
    {
        return isAuthorized(Cafe::class, 'edit', $user) ? Response::allow() : Response::deny('You are not allowed to edit the cafe_service.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Cafe $cafe_service
     * @return mixed
     */
    public function delete(User $user, Cafe $cafe_service)
    {
        return isAuthorized(Cafe::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to archive the cafe_service.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Cafe $cafe_service
     * @return mixed
     */
    public function restore(User $user, Cafe $cafe_service)
    {
        return isAuthorized(Cafe::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to restore the cafe_service.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Cafe $cafe_service
     * @return mixed
     */
    public function forceDelete(User $user, Cafe $cafe_service)
    {
        return isAuthorized(Cafe::class, 'delete', $user) ? Response::allow() : Response::deny('You are not allowed to delete the cafe_service.');
    }
}
