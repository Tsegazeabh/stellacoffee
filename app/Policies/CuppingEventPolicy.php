<?php

namespace App\Policies;

use App\Models\CuppingEvent;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class CuppingEventPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view cupping events.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CuppingEvent  $cuppingEvent
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, CuppingEvent $cuppingEvent)
    {
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view cupping events.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return isAuthorized(CuppingEvent::class, 'create', $user) ? Response::allow() : Response::deny('You are not allowed to create cupping event.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CuppingEvent  $cuppingEvent
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, CuppingEvent $cuppingEvent)
    {
        return isAuthorized(CuppingEvent::class, 'edit', $user) ? Response::allow() : Response::deny('You are not allowed to edit cupping event.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CuppingEvent  $cuppingEvent
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, CuppingEvent $cuppingEvent)
    {
        return isAuthorized(CuppingEvent::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to archive cupping event.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CuppingEvent  $cuppingEvent
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, CuppingEvent $cuppingEvent)
    {
        return isAuthorized(CuppingEvent::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to restore cupping event.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CuppingEvent  $cuppingEvent
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, CuppingEvent $cuppingEvent)
    {
        return isAuthorized(CuppingEvent::class, 'delete', $user) ? Response::allow() : Response::deny('You are not allowed to delete cupping event.');
    }
}
