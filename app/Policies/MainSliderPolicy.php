<?php

namespace App\Policies;

use App\Models\MainSlider;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class MainSliderPolicy
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
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view the main slider.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\MainSlider $main_slider
     * @return mixed
     */
    public function view(User $user, MainSlider $main_slider)
    {
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view the main slider.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return isAuthorized(MainSlider::class, 'create', $user) ? Response::allow() : Response::deny('You are not allowed to create a main slider.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\MainSlider $main_slider
     * @return mixed
     */
    public function update(User $user, MainSlider $main_slider)
    {
        return isAuthorized(MainSlider::class, 'edit', $user) ? Response::allow() : Response::deny('You are not allowed to edit the main slider.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\MainSlider $main_slider
     * @return mixed
     */
    public function delete(User $user, MainSlider $main_slider)
    {
        return isAuthorized(MainSlider::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to archive the main slider.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\MainSlider $main_slider
     * @return mixed
     */
    public function restore(User $user, MainSlider $main_slider)
    {
        return isAuthorized(MainSlider::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to restore the main slider.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\MainSlider $main_slider
     * @return mixed
     */
    public function forceDelete(User $user, MainSlider $main_slider)
    {
        return isAuthorized(MainSlider::class, 'delete', $user) ? Response::allow() : Response::deny('You are not allowed to delete the main slider.');
    }
}
