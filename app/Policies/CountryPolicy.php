<?php

namespace App\Policies;

use App\Models\Country;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class CountryPolicy
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
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view the country.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Country $country
     * @return mixed
     */
    public function view(User $user, Country $country)
    {
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view the country.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return isAuthorized(Country::class, 'create', $user) ? Response::allow() : Response::deny('You are not allowed to create a country.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Country $country
     * @return mixed
     */
    public function update(User $user, Country $country)
    {
        return isAuthorized(Country::class, 'edit', $user) ? Response::allow() : Response::deny('You are not allowed to edit the country.');
    }


//    /**
//     * Determine whether the user can restore the model.
//     *
//     * @param \App\Models\User $user
//     * @param \App\Models\Country $country
//     * @return mixed
//     */
//    public function restore(User $user, Country $country)
//    {
//        return isAuthorized(Country::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to restore the country.');
//    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Country $country
     * @return mixed
     */
    public function forceDelete(User $user, Country $country)
    {
        return isAuthorized(Country::class, 'delete', $user) ? Response::allow() : Response::deny('You are not allowed to delete the country.');
    }
}
