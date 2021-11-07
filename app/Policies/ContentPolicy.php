<?php

namespace App\Policies;

use App\Models\Content;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class ContentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Content  $content
     * @return mixed
     */
    public function view(User $user, Content $content)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {

    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Content  $content
     * @return mixed
     */
    public function update(User $user, Content $content)
    {
        return isAuthorized($content->contentable_type, 'edit', $user) ? Response::allow() : Response::deny('You are not allow to edit the content.');
    }

    /**
     * Determine whether the user can publish the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Content  $content
     * @return mixed
     */
    public function publish(User $user, Content $content)
    {
        return isAuthorized($content->contentable_type, 'publish', $user) ? Response::allow() : Response::deny('You are not allowed to publish the content.');
    }

    /**
     * Determine whether the user can unpublish the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Content  $content
     * @return mixed
     */
    public function unpublish(User $user, Content $content)
    {
        return isAuthorized($content->contentable_type, 'unpublish', $user) ? Response::allow() : Response::deny('You are not allowed to un-publish the content.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Content  $content
     * @return mixed
     */
    public function delete(User $user, Content $content)
    {
        return isAuthorized($content->contentable_type, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to archive the content.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Content  $content
     * @return mixed
     */
    public function restore(User $user, Content $content)
    {
        return isAuthorized($content->contentable_type, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to restore the content.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Content  $content
     * @return mixed
     */
    public function forceDelete(User $user, Content $content)
    {
        return isAuthorized($content->contentable_type, 'delete', $user) ? Response::allow() : Response::deny('You are not allowed to delete the content.');
    }
}
