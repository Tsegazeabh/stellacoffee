<?php

namespace App\Policies;

use App\Models\Region;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class RegionPolicy
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
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view the news.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Region $news
     * @return mixed
     */
    public function view(User $user, Region $news)
    {
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view the region.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return isAuthorized(Region::class, 'create', $user) ? Response::allow() : Response::deny('You are not allowed to create a region.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Region $region
     * @return mixed
     */
    public function update(User $user, Region $region)
    {
        return isAuthorized(Region::class, 'edit', $user) ? Response::allow() : Response::deny('You are not allowed to edit the region.');
    }

//    /**
//     * Determine whether the user can delete the model.
//     *
//     * @param \App\Models\User $user
//     * @param \App\Models\Region $region
//     * @return mixed
//     */
//    public function delete(User $user, Region $region)
//    {
//        return isAuthorized(Region::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to archive the region.');
//    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Region $region
     * @return mixed
     */
    public function forceDelete(User $user, Region $region)
    {
        return isAuthorized(Region::class, 'delete', $user) ? Response::allow() : Response::deny('You are not allowed to delete the region.');
    }
}
