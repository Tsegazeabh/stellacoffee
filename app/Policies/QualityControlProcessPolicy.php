<?php

namespace App\Policies;

use App\Models\QualityControlProcess;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class QualityControlProcessPolicy
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
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view the quality_control_process.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\QualityControlProcess $quality_control_process
     * @return mixed
     */
    public function view(User $user, QualityControlProcess $quality_control_process)
    {
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view the quality_control_process.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return isAuthorized(QualityControlProcess::class, 'create', $user) ? Response::allow() : Response::deny('You are not allowed to create a quality_control_process.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\QualityControlProcess $quality_control_process
     * @return mixed
     */
    public function update(User $user, QualityControlProcess $quality_control_process)
    {
        return isAuthorized(QualityControlProcess::class, 'edit', $user) ? Response::allow() : Response::deny('You are not allowed to edit the quality_control_process.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\QualityControlProcess $quality_control_process
     * @return mixed
     */
    public function delete(User $user, QualityControlProcess $quality_control_process)
    {
        return isAuthorized(QualityControlProcess::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to archive the quality_control_process.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\QualityControlProcess $quality_control_process
     * @return mixed
     */
    public function restore(User $user, QualityControlProcess $quality_control_process)
    {
        return isAuthorized(QualityControlProcess::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to restore the quality_control_process.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\QualityControlProcess $quality_control_process
     * @return mixed
     */
    public function forceDelete(User $user, QualityControlProcess $quality_control_process)
    {
        return isAuthorized(QualityControlProcess::class, 'delete', $user) ? Response::allow() : Response::deny('You are not allowed to delete the quality_control_process.');
    }
}
