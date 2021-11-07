<?php

namespace App\Policies;

use App\Models\ContactUsRequest;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class ContactUsRequestPolicy
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
        return Auth::check() ? Response::allow() : Response::deny('You are not allowed to view the contact us request.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\ContactUsRequest $contact_us_request
     * @return mixed
     */
    public function view(User $user, ContactUsRequest $contact_us_request)
    {
        return isAuthorized(ContactUsRequest::class, 'view', $user) ? Response::allow() : Response::deny('You are not allowed to view the contact us request.');
    }

    /**
     * Determine whether the user can close the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\ContactUsRequest $contact_us_request
     * @return mixed
     */
    public function closeUpdate(User $user, ContactUsRequest $contact_us_request)
    {
        return isAuthorized(ContactUsRequest::class, 'closeUpdate', $user) ? Response::allow() : Response::deny('You are not allowed to close the contact us request.');
    }
    /**
     * Determine whether the user can open the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\ContactUsRequest $contact_us_request
     * @return mixed
     */
    public function openUpdate(User $user, ContactUsRequest $contact_us_request)
    {
        return isAuthorized(ContactUsRequest::class, 'openUpdate', $user) ? Response::allow() : Response::deny('You are not allowed to open the contact us request.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\ContactUsRequest $contact_us_request
     * @return mixed
     */
    public function delete(User $user, ContactUsRequest $contact_us_request)
    {
        return isAuthorized(ContactUsRequest::class, 'delete', $user) ? Response::allow() : Response::deny('You are not allowed to delete the contact us request.');
    }
    public function archive(User $user, ContactUsRequest $contact_us_request)
    {
        return isAuthorized(ContactUsRequest::class, 'archive', $user) ? Response::allow() : Response::deny('You are not allowed to archive the the contact us request.');
    }
}
