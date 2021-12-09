<?php

namespace App\Policies;

use App\Models\CustomerTestimonial;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class CustomerTestimonialPolicy
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
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view customer testimonials.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CustomerTestimonial  $customerTestimonial
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, CustomerTestimonial $customerTestimonial)
    {
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view customer testimonials.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return isAuthorized(CustomerTestimonial::class, 'create', $user) ? Response::allow() : Response::deny('You are not allowed to create customer testimonial.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CustomerTestimonial  $customerTestimonial
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, CustomerTestimonial $customerTestimonial)
    {
        return isAuthorized(CustomerTestimonial::class, 'edit', $user) ? Response::allow() : Response::deny('You are not allowed to edit customer testimonial.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CustomerTestimonial  $customerTestimonial
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, CustomerTestimonial $customerTestimonial)
    {
        return isAuthorized(CustomerTestimonial::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to archive customer testimonial.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CustomerTestimonial  $customerTestimonial
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, CustomerTestimonial $customerTestimonial)
    {
        return isAuthorized(CustomerTestimonial::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to restore customer testimonial.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CustomerTestimonial  $customerTestimonial
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, CustomerTestimonial $customerTestimonial)
    {
        return isAuthorized(CustomerTestimonial::class, 'delete', $user) ? Response::allow() : Response::deny('You are not allowed to delete customer testimonial.');
    }
}
