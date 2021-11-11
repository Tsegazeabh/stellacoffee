<?php

namespace App\Policies;

use App\Models\TermAndCondition;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class TermAndConditionPolicy
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
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view the terms and conditions.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\TermAndCondition $term_and_condition
     * @return mixed
     */
    public function view(User $user, TermAndCondition $term_and_condition)
    {
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view the terms and conditions.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return isAuthorized(TermAndCondition::class, 'create', $user) ? Response::allow() : Response::deny('You are not allowed to create a terms and conditions.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\TermAndCondition $term_and_condition
     * @return mixed
     */
    public function update(User $user, TermAndCondition $term_and_condition)
    {
        return isAuthorized(TermAndCondition::class, 'edit', $user) ? Response::allow() : Response::deny('You are not allowed to edit the terms and conditions.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\TermAndCondition $term_and_condition
     * @return mixed
     */
    public function delete(User $user, TermAndCondition $term_and_condition)
    {
        return isAuthorized(TermAndCondition::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to archive the terms and conditions.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\TermAndCondition $term_and_condition
     * @return mixed
     */
    public function restore(User $user, TermAndCondition $term_and_condition)
    {
        return isAuthorized(TermAndCondition::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to restore the terms and conditions.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\TermAndCondition $term_and_condition
     * @return mixed
     */
    public function forceDelete(User $user, TermAndCondition $term_and_condition)
    {
        return isAuthorized(TermAndCondition::class, 'delete', $user) ? Response::allow() : Response::deny('You are not allowed to delete the terms and conditions.');
    }
}
