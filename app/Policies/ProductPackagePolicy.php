<?php

namespace App\Policies;

use App\Models\ProductPackage;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class ProductPackagePolicy
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
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view the product_package.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\ProductPackage $product_package
     * @return mixed
     */
    public function view(User $user, ProductPackage $product_package)
    {
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view the product_package.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return isAuthorized(ProductPackage::class, 'create', $user) ? Response::allow() : Response::deny('You are not allowed to create a product_package.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\ProductPackage $product_package
     * @return mixed
     */
    public function update(User $user, ProductPackage $product_package)
    {
        return isAuthorized(ProductPackage::class, 'edit', $user) ? Response::allow() : Response::deny('You are not allowed to edit the product_package.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\ProductPackage $product_package
     * @return mixed
     */
    public function delete(User $user, ProductPackage $product_package)
    {
        return isAuthorized(ProductPackage::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to archive the product_package.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\ProductPackage $product_package
     * @return mixed
     */
    public function restore(User $user, ProductPackage $product_package)
    {
        return isAuthorized(ProductPackage::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to restore the product_package.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\ProductPackage $product_package
     * @return mixed
     */
    public function forceDelete(User $user, ProductPackage $product_package)
    {
        return isAuthorized(ProductPackage::class, 'delete', $user) ? Response::allow() : Response::deny('You are not allowed to delete the product_package.');
    }
}
