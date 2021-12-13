<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\CMS\ServiceTypeRequest;
use App\Models\ServiceType;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ServiceTypeController extends Controller
{
    function __construct()
    {
    }
    /**
     * Display a listing of the resource management such as create, edit, delete, and show.
     *
     * @return \Inertia\Response
     */
    protected function manageServiceType(Request $request)
    {
        try {
            $sort_by = $request->get('current_sorting_col', getDefaultSortingColumn());

            if (mb_strlen($sort_by) == 0) {
                $sort_by = getDefaultSortingColumn();
            }

            $sorting_method = $request->get('sorting_method', getDefaultSortingMethod());
            if (mb_strlen($sorting_method) == 0) {
                $sorting_method = getDefaultSortingMethod();
            }

            $paging_size = getDefaultPagingSize();

            $searchResult = ServiceType::orderBy($sort_by, $sorting_method)->paginate($paging_size);

            $data['searchResult'] = $searchResult;

            return $request->wantsJson() ? new JsonResponse($searchResult) : Inertia::render('CMS/ServiceType/ManageServiceType', $data);

        } catch (\Throwable $ex) {
            report($ex);
            return $request->wantsJson() ? new JsonResponse(getGeneralAdminErrorMessage(), 503) : back()->with('errorMessage', getGeneralAdminErrorMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    protected function createGet()
    {
        try {
            $this->authorize('create', new ServiceType);
            return Inertia::render('CMS/ServiceType/CreateServiceType');
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function createPost(ServiceTypeRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->authorize('create', new ServiceType);
            $service_type = $request->all();
            ServiceType::create($service_type);
            DB::commit();
            Log::info($service_type);
            return redirect()->route('service-type-management-page');
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ServiceType  $events
     * @return \Inertia\Response
     */
    protected function editGet($service_type_id)
    {
        try {
            $service_type = ServiceType::find($service_type_id);
            $this->authorize('update', $service_type);
            $data['service_type'] = $service_type;
            return Inertia::render('CMS/ServiceType/EditServiceType', $data);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ServiceType  $service_type
     * @return \Illuminate\Http\Response
     */
    protected function editPost(ServiceTypeRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $service_type = ServiceType::find($id);
            $this->authorize('update', $service_type);
            if ($service_type != null) {
                $service_type->update($request->all());
            }
            else {
                return $request->wantsJson() ? new JsonResponse('We can not find a service type with the specified id', 404) : bacK()->with('errorMessage', 'We can not find a service type with the specified id!');
            }
            DB::commit();
            return redirect()->route('service-type-management-page');
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServiceType  $service_type
     * @return \Illuminate\Http\Response
     */
    protected function delete(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $service_type = ServiceType::find($id);
            $this->authorize('forceDelete', $service_type);
            if ($service_type != null) {
                $service_type->delete();
                DB::commit();
            } else {
                return $request->wantsJson() ? new JsonResponse(getContentUnpublishedNotificationMessage()) : bacK()->with('successMessage', getContentUnpublishedNotificationMessage());
            }
            return $request->wantsJson() ? new JsonResponse('We can not find a service type with the specified id', 404) : bacK()->with('errorMessage', 'We can not find a service type with the specified id!');
        } catch (\Throwable $ex) {
            DB::rollback();
            logError($ex);
            if ($ex instanceof AuthorizationException) {
                abort(403, getUnAuthorizedAccessMessage());
            }
            return $request->wantsJson() ? new JsonResponse(getGeneralAdminErrorMessage(), 503) : back()->with('errorMessage', getGeneralAdminErrorMessage());
        }
    }
}
