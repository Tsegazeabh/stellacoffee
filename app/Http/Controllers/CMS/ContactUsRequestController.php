<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\CMS\ContactUsFormRequest;
use App\Mail\ContactUsRequestMailable;
use App\Models\ContactUsRequest;
use App\Models\Locale;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ContactUsRequestController extends Controller
{
    function __construct()
    {
    }

    /**
     * @return \Inertia\Response
     */
    protected function createGet()
    {
        try {
            return Inertia::render('Public/ContactUsRequest/CreateContactUsRequest');
        } catch (AuthorizationException $ex) {
            abort(403);
        } catch (\Exception $ex) {
            logError($ex);
            if ($ex instanceof NotFoundHttpException) {
                abort(404);
            }
            return Inertia::render('Errors/UnhandledException');
        }
    }

    /**
     * @param CreateContactUsRequest $request
     * @return JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function createPost(ContactUsFormRequest $request)
    {
        DB::beginTransaction();
        try {
            $locale = Locale::where('short_code', getSessionLanguageShortCode())->first();
            $content = array('locale_id' => $locale->id);
            $contact_us_request = $request->all();
            $contact_us_request_created = ContactUsRequest::create(array_merge($contact_us_request, $content));
            // To send the email to the sender him/her self and to the recipient. The email is statitically given
            Mail::queue(new ContactUsRequestMailable($contact_us_request_created));
            DB::commit();
            return back()->with('successMessage', 'Request is submitted successfully');
        } catch (\Throwable $ex) {
            DB::rollback();
            logError($ex);
            if ($ex instanceof AuthorizationException) {
                abort(403, getUnAuthorizedAccessMessage());
            }
            return back()->withErrors(['errorMessage' => getGeneralAdminErrorMessage()]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse|\Illuminate\Http\RedirectResponse|\Inertia\Response
     */
    protected function manageContactUsRequest(Request $request)
    {
        try {
            $paging_size = getDefaultPagingSize();
            $data['pagingSize'] = $paging_size;
            return Inertia::render('CMS/ContactUsRequest/ManageContactUsRequest', $data);
        } catch (\Throwable $ex) {
            report($ex);
            return back()->withErrors(['errorMessage' => getGeneralAdminErrorMessage()]);
        }
    }

    protected function fetchContactUsRequest(Request $request)
    {
        try {
            $request['page'] = $request->get('currentPage') + 1;
            $pageSize = $request->get('pageSize', getDefaultPagingSize());
            $sortingColumn = $request->get('sortingColumn');
            $sortingDirection = $request->get('sortingDirection', getDefaultSortingMethod());

            if (mb_strlen($sortingColumn) == 0) {
                $sortingColumn = getDefaultSortingColumn();
            }
            $content_status = $request->has('simpleFilters') ? $request->get('simpleFilters')['content_status'] : 0;

            $searchKeyword = $request->has('simpleFilters') ? $request->get('simpleFilters')['search_keyword'] : '';
            switch ($content_status) {
                case 1: // open
                    $result = ContactUsRequest::withTrashed()
                        ->with('country')
                        ->where('status', 1)
                        ->ofLanguage(getSessionLanguageId())
                        ->search($searchKeyword)
                        ->sortBy($sortingColumn, $sortingDirection, ContactUsRequest::class)
                        ->paginate($pageSize);
                    break;
                case 2 : //close
                    $result = ContactUsRequest::withTrashed()
                        ->with('country')
                        ->where('status', 0)
                        ->ofLanguage(getSessionLanguageId())
                        ->search($searchKeyword)
                        ->sortBy($sortingColumn, $sortingDirection, ContactUsRequest::class)
                        ->paginate($pageSize);
                    break;
                default: //any
                    $result = ContactUsRequest::withTrashed()
                        ->with('country')
                        ->ofLanguage(getSessionLanguageId())
                        ->search($searchKeyword)
                        ->sortBy($sortingColumn, $sortingDirection, ContactUsRequest::class)
                        ->paginate($pageSize);
                    break;
            }
            Log::info('Result: '.$result);
            return new JsonResponse($result);
        } catch (\Throwable $ex) {
            report($ex);
            return new JsonResponse(getGeneralAdminErrorMessage(), 503);
        }
    }

    /**
     * @param Request $request
     * @param $contentId
     * @return JsonResponse|\Illuminate\Http\RedirectResponse|\Inertia\Response
     */
    protected function detailGet(Request $request, $id)
    {
        try {
            $contact_us_request = ContactUsRequest::with('country')->withTrashed()->find($id);
            $this->authorize('view', $contact_us_request);
            $data['contact_us_request'] = $contact_us_request;
            return $request->wantsJson() ? new JsonResponse($contact_us_request) : Inertia::render('CMS/ContactUsRequest/ContactUsRequestDetail', $data);

        } catch (\Throwable $ex) {
            logError($ex);
            return $request->wantsJson() ? new JsonResponse(getGeneralAdminErrorMessage(), 503) : back()->with('errorMessage', getGeneralAdminErrorMessage());
        }
    }

    protected function closeUpdate(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $contact_us_request = ContactUsRequest::find($id);
            $this->authorize('closeUpdate', $contact_us_request);
            if ($contact_us_request != null) {
                $contact_us_request->status = false;
                $contact_us_request->update();
                DB::commit();
                return $request->wantsJson() ? new JsonResponse('Contact Us Request is closed successfully') : redirect()->route('contact-us-request-management-page', ['successMessage' => 'Contact Us Request database is updated successfully']);
            } else {
                return $request->wantsJson() ? new JsonResponse('We can not find a contact us request with the specified id', 404) : bacK()->with('errorMessage', 'We can not find a Contact Us Request with the specified id!');
            }
        } catch (\Throwable $ex) {
            DB::rollback();
            logError($ex);
            if ($ex instanceof AuthorizationException) {
                abort(403, getUnAuthorizedAccessMessage());
            }
            return $request->wantsJson() ? new JsonResponse(getGeneralAdminErrorMessage(), 503) : back()->with('errorMessage', getGeneralAdminErrorMessage());
        }
    }

    protected function openUpdate(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $contact_us_request = ContactUsRequest::find($id);
            $this->authorize('openUpdate', $contact_us_request);
            if ($contact_us_request != null) {
                $contact_us_request->status = true;
                $contact_us_request->update();
                DB::commit();
                return $request->wantsJson() ? new JsonResponse('Contact Us Request is opened successfully') : redirect()->route('contact-us-request-management-page', ['successMessage' => 'Contact Us Request database is updated successfully']);
            } else {
                return $request->wantsJson() ? new JsonResponse('We can not find a contact us request with the specified id', 404) : bacK()->with('errorMessage', 'We can not find a Contact Us Request with the specified id!');
            }
        } catch (\Throwable $ex) {
            DB::rollback();
            logError($ex);
            if ($ex instanceof AuthorizationException) {
                abort(403, getUnAuthorizedAccessMessage());
            }
            return $request->wantsJson() ? new JsonResponse(getGeneralAdminErrorMessage(), 503) : back()->with('errorMessage', getGeneralAdminErrorMessage());
        }
    }

    protected function archive(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $contact_us_request = ContactUsRequest::find($id);
            $this->authorize('archive', $contact_us_request);
            if ($contact_us_request != null) {
                $contact_us_request->deleted_by = Auth::user()->getAuthIdentifier();
                $contact_us_request->delete();
                DB::commit();
                return $request->wantsJson() ? new JsonResponse(getContentArchivedNotificationMessage()) : bacK()->with('successMessage', getContentArchivedNotificationMessage());
            } else {
                return $request->wantsJson() ? new JsonResponse('We can not find a contact us request with the specified id', 404) : bacK()->with('errorMessage', 'We can not find a contact us request with the specified id!');
            }

        } catch (\Throwable $ex) {
            DB::rollback();
            logError($ex);
            if ($ex instanceof AuthorizationException) {
                abort(403, getUnAuthorizedAccessMessage());
            }
            return $request->wantsJson() ? new JsonResponse(getGeneralAdminErrorMessage(), 503) : back()->with('errorMessage', getGeneralAdminErrorMessage());
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function delete(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $contact_us_request = ContactUsRequest::withTrashed()->find($id);
            $this->authorize('delete', $contact_us_request);
            if ($contact_us_request != null) {
                $contact_us_request->delete();
                $contact_us_request->forceDelete();
                DB::commit();
                return response(getContentDeletedNotificationMessage(), 200);
            } else {
                return response('We can not find a contact us request with the specified id', 404);
            }
        } catch (\Throwable $ex) {
            DB::rollback();
            logError($ex);
            if ($ex instanceof AuthorizationException) {
                abort(403, getUnAuthorizedAccessMessage());
            }
            return response(getGeneralAdminErrorMessage(), 503);
        }
    }
}
