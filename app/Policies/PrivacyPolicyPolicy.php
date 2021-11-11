<?php

namespace App\Policies;

use App\Models\PrivacyPolicy;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class PrivacyPolicyPolicy
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
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view the privacy policy.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\PrivacyPolicy $privacy_policy
     * @return mixed
     */
    public function view(User $user, PrivacyPolicy $privacy_policy)
    {
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view the privacy policy.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return isAuthorized(PrivacyPolicy::class, 'create', $user) ? Response::allow() : Response::deny('You are not allowed to create a privacy policy.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\PrivacyPolicy $privacy_policy
     * @return mixed
     */
    public function update(User $user, PrivacyPolicy $privacy_policy)
    {
        return isAuthorized(PrivacyPolicy::class, 'edit', $user) ? Response::allow() : Response::deny('You are not allowed to edit the privacy policy.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\PrivacyPolicy $privacy_policy
     * @return mixed
     */
    public function delete(User $user, PrivacyPolicy $privacy_policy)
    {
        return isAuthorized(PrivacyPolicy::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to archive the privacy policy.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\PrivacyPolicy $privacy_policy
     * @return mixed
     */
    public function restore(User $user, PrivacyPolicy $privacy_policy)
    {
        return isAuthorized(PrivacyPolicy::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to restore the privacy policy.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\PrivacyPolicy $privacy_policy
     * @return mixed
     */
    public function forceDelete(User $user, PrivacyPolicy $privacy_policy)
    {
        return isAuthorized(PrivacyPolicy::class, 'delete', $user) ? Response::allow() : Response::deny('You are not allowed to delete the privacy policy.');
    }
}
