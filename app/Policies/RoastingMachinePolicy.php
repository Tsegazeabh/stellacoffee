<?php

namespace App\Policies;

use App\Models\RoastingMachine;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class RoastingMachinePolicy
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
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view the roasting_machine.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\RoastingMachine $roasting_machine
     * @return mixed
     */
    public function view(User $user, RoastingMachine $roasting_machine)
    {
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view the roasting_machine.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return isAuthorized(RoastingMachine::class, 'create', $user) ? Response::allow() : Response::deny('You are not allowed to create a roasting_machine.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\RoastingMachine $roasting_machine
     * @return mixed
     */
    public function update(User $user, RoastingMachine $roasting_machine)
    {
        return isAuthorized(RoastingMachine::class, 'edit', $user) ? Response::allow() : Response::deny('You are not allowed to edit the roasting_machine.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\RoastingMachine $roasting_machine
     * @return mixed
     */
    public function delete(User $user, RoastingMachine $roasting_machine)
    {
        return isAuthorized(RoastingMachine::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to archive the roasting_machine.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\RoastingMachine $roasting_machine
     * @return mixed
     */
    public function restore(User $user, RoastingMachine $roasting_machine)
    {
        return isAuthorized(RoastingMachine::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to restore the roasting_machine.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\RoastingMachine $roasting_machine
     * @return mixed
     */
    public function forceDelete(User $user, RoastingMachine $roasting_machine)
    {
        return isAuthorized(RoastingMachine::class, 'delete', $user) ? Response::allow() : Response::deny('You are not allowed to delete the roasting_machine.');
    }
}
