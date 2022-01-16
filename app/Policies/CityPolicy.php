<?php

namespace App\Policies;

use App\Models\City;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class CityPolicy
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
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view the city.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\City $city
     * @return mixed
     */
    public function view(User $user, City $city)
    {
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view the city.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return isAuthorized(City::class, 'create', $user) ? Response::allow() : Response::deny('You are not allowed to create a city.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\City $city
     * @return mixed
     */
    public function update(User $user, City $city)
    {
        return isAuthorized(City::class, 'edit', $user) ? Response::allow() : Response::deny('You are not allowed to edit the city.');
    }


//    /**
//     * Determine whether the user can restore the model.
//     *
//     * @param \App\Models\User $user
//     * @param \App\Models\City $city
//     * @return mixed
//     */
//    public function restore(User $user, City $city)
//    {
//        return isAuthorized(City::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to restore the city.');
//    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\City $city
     * @return mixed
     */
    public function forceDelete(User $user, City $city)
    {
        return isAuthorized(City::class, 'delete', $user) ? Response::allow() : Response::deny('You are not allowed to delete the city.');
    }
}
