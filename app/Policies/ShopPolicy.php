<?php

namespace App\Policies;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class ShopPolicy
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
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view shops.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Shop $shop)
    {
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view shops.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return isAuthorized(Shop::class, 'create', $user) ? Response::allow() : Response::deny('You are not allowed to create shop.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Shop $shop)
    {
        return isAuthorized(Shop::class, 'edit', $user) ? Response::allow() : Response::deny('You are not allowed to update shop detail.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Shop $shop)
    {
        return isAuthorized(Shop::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to archive shop.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Shop $shop)
    {
        return isAuthorized(Shop::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to restore shop.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Shop $shop)
    {
        return isAuthorized(Shop::class, 'delete', $user) ? Response::allow() : Response::deny('You are not allowed to delete shop.');
    }
}
