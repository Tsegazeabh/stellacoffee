<?php

namespace App\Policies;

use App\Models\ServiceType;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class ServiceTypePolicy
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
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view the service_type.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\ServiceType $service_type
     * @return mixed
     */
    public function view(User $user, ServiceType $service_type)
    {
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view the service_type.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return isAuthorized(ServiceType::class, 'create', $user) ? Response::allow() : Response::deny('You are not allowed to create a service_type.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\ServiceType $service_type
     * @return mixed
     */
    public function update(User $user, ServiceType $service_type)
    {
        return isAuthorized(ServiceType::class, 'edit', $user) ? Response::allow() : Response::deny('You are not allowed to edit the service_type.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\ServiceType $service_type
     * @return mixed
     */
    public function delete(User $user, ServiceType $service_type)
    {
        return isAuthorized(ServiceType::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to archive the service_type.');
    }


    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\ServiceType $service_type
     * @return mixed
     */
    public function forceDelete(User $user, ServiceType $service_type)
    {
        return isAuthorized(ServiceType::class, 'delete', $user) ? Response::allow() : Response::deny('You are not allowed to delete the service_type.');
    }
}
