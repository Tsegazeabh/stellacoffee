<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Partner;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class PartnerPolicy
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
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view the partner.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Partner $partner
     * @return mixed
     */
    public function view(User $user, Partner $partner)
    {
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view the partner.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return isAuthorized(Partner::class, 'create', $user) ? Response::allow() : Response::deny('You are not allowed to create a partner.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Partner $partner
     * @return mixed
     */
    public function update(User $user, Partner $partner)
    {
        return isAuthorized(Partner::class, 'edit', $user) ? Response::allow() : Response::deny('You are not allowed to edit the partner.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Partner $partner
     * @return mixed
     */
    public function delete(User $user, Partner $partner)
    {
        return isAuthorized(Partner::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to archive the partner.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Partner $partner
     * @return mixed
     */
    public function restore(User $user, Partner $partner)
    {
        return isAuthorized(Partner::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to restore the partner.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Partner $partner
     * @return mixed
     */
    public function forceDelete(User $user, Partner $partner)
    {
        return isAuthorized(Partner::class, 'delete', $user) ? Response::allow() : Response::deny('You are not allowed to delete the partner.');
    }
}
