<?php

namespace App\Policies;

use App\Models\StellaCoffeeOrigin;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class StellaCoffeOriginPolicy
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
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view the stella_coffee_origin.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\StellaCoffeeOrigin $stella_coffee_origin
     * @return mixed
     */
    public function view(User $user, StellaCoffeeOrigin $stella_coffee_origin)
    {
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view the stella_coffee_origin.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return isAuthorized(StellaCoffeeOrigin::class, 'create', $user) ? Response::allow() : Response::deny('You are not allowed to create a stella_coffee_origin.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\StellaCoffeeOrigin $stella_coffee_origin
     * @return mixed
     */
    public function update(User $user, StellaCoffeeOrigin $stella_coffee_origin)
    {
        return isAuthorized(StellaCoffeeOrigin::class, 'edit', $user) ? Response::allow() : Response::deny('You are not allowed to edit the stella_coffee_origin.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\StellaCoffeeOrigin $stella_coffee_origin
     * @return mixed
     */
    public function delete(User $user, StellaCoffeeOrigin $stella_coffee_origin)
    {
        return isAuthorized(StellaCoffeeOrigin::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to archive the stella_coffee_origin.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\StellaCoffeeOrigin $stella_coffee_origin
     * @return mixed
     */
    public function restore(User $user, StellaCoffeeOrigin $stella_coffee_origin)
    {
        return isAuthorized(StellaCoffeeOrigin::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to restore the stella_coffee_origin.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\StellaCoffeeOrigin $stella_coffee_origin
     * @return mixed
     */
    public function forceDelete(User $user, StellaCoffeeOrigin $stella_coffee_origin)
    {
        return isAuthorized(StellaCoffeeOrigin::class, 'delete', $user) ? Response::allow() : Response::deny('You are not allowed to delete the stella_coffee_origin.');
    }
}
