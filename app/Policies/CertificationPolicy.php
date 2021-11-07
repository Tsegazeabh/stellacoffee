<?php

namespace App\Policies;

use App\Models\Certification;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class CertificationPolicy
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
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view the certification.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Certification $certification
     * @return mixed
     */
    public function view(User $user, Certification $certification)
    {
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view the certification.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return isAuthorized(Certification::class, 'create', $user) ? Response::allow() : Response::deny('You are not allowed to create a certification.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Certification $certification
     * @return mixed
     */
    public function update(User $user, Certification $certification)
    {
        return isAuthorized(Certification::class, 'edit', $user) ? Response::allow() : Response::deny('You are not allowed to edit the certification.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Certification $certification
     * @return mixed
     */
    public function delete(User $user, Certification $certification)
    {
        return isAuthorized(Certification::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to archive the certification.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Certification $certification
     * @return mixed
     */
    public function restore(User $user, Certification $certification)
    {
        return isAuthorized(Certification::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to restore the certification.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Certification $certification
     * @return mixed
     */
    public function forceDelete(User $user, Certification $certification)
    {
        return isAuthorized(Certification::class, 'delete', $user) ? Response::allow() : Response::deny('You are not allowed to delete the certification.');
    }
}
