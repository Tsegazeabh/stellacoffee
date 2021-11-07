<?php

namespace App\Policies;

use App\Models\SuccessStory;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class SuccessStoryPolicy
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
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view the success_story.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\SuccessStory $success_story
     * @return mixed
     */
    public function view(User $user, SuccessStory $success_story)
    {
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view the success_story.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return isAuthorized(SuccessStory::class, 'create', $user) ? Response::allow() : Response::deny('You are not allowed to create a success_story.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\SuccessStory $success_story
     * @return mixed
     */
    public function update(User $user, SuccessStory $success_story)
    {
        return isAuthorized(SuccessStory::class, 'edit', $user) ? Response::allow() : Response::deny('You are not allowed to edit the success_story.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\SuccessStory $success_story
     * @return mixed
     */
    public function delete(User $user, SuccessStory $success_story)
    {
        return isAuthorized(SuccessStory::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to archive the success_story.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\SuccessStory $success_story
     * @return mixed
     */
    public function restore(User $user, SuccessStory $success_story)
    {
        return isAuthorized(SuccessStory::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to restore the success_story.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\SuccessStory $success_story
     * @return mixed
     */
    public function forceDelete(User $user, SuccessStory $success_story)
    {
        return isAuthorized(SuccessStory::class, 'delete', $user) ? Response::allow() : Response::deny('You are not allowed to delete the success_story.');
    }
}
