<?php

namespace App\Policies;

use App\Models\ExportProcess;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class ExportProcessPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view export process.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\ExportProcess $exportProcess
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ExportProcess $exportProcess)
    {
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view export process.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return isAuthorized(ExportProcess::class, 'create', $user) ? Response::allow() : Response::deny('You are not allowed to create export process.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\ExportProcess $exportProcess
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ExportProcess $exportProcess)
    {
        return isAuthorized(ExportProcess::class, 'edit', $user) ? Response::allow() : Response::deny('You are not allowed to update export process.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\ExportProcess $exportProcess
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ExportProcess $exportProcess)
    {
        return isAuthorized(ExportProcess::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to archive export process.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\ExportProcess $exportProcess
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, ExportProcess $exportProcess)
    {
        return isAuthorized(ExportProcess::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to restore export process.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\ExportProcess $exportProcess
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, ExportProcess $exportProcess)
    {
        return isAuthorized(ExportProcess::class, 'delete', $user) ? Response::allow() : Response::deny('You are not allowed to delete export process.');
    }
}
