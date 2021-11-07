<?php

namespace App\Policies;

use App\Models\RoastingGuide;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class RoastingGuidePolicy
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
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view the roasting_guide.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\RoastingGuide $roasting_guide
     * @return mixed
     */
    public function view(User $user, RoastingGuide $roasting_guide)
    {
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view the roasting_guide.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return isAuthorized(RoastingGuide::class, 'create', $user) ? Response::allow() : Response::deny('You are not allowed to create a roasting_guide.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\RoastingGuide $roasting_guide
     * @return mixed
     */
    public function update(User $user, RoastingGuide $roasting_guide)
    {
        return isAuthorized(RoastingGuide::class, 'edit', $user) ? Response::allow() : Response::deny('You are not allowed to edit the roasting_guide.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\RoastingGuide $roasting_guide
     * @return mixed
     */
    public function delete(User $user, RoastingGuide $roasting_guide)
    {
        return isAuthorized(RoastingGuide::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to archive the roasting_guide.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\RoastingGuide $roasting_guide
     * @return mixed
     */
    public function restore(User $user, RoastingGuide $roasting_guide)
    {
        return isAuthorized(RoastingGuide::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to restore the roasting_guide.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\RoastingGuide $roasting_guide
     * @return mixed
     */
    public function forceDelete(User $user, RoastingGuide $roasting_guide)
    {
        return isAuthorized(RoastingGuide::class, 'delete', $user) ? Response::allow() : Response::deny('You are not allowed to delete the roasting_guide.');
    }
}
