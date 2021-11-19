<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\CMS\RegionRequest;
use App\Models\Region;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RegionController extends Controller
{
    function __construct()
    {
    }

    /**
     * Display a listing of the resource management such as create, edit, delete, and show.
     *
     * @return \Inertia\Response
     */
    protected function manageRegion(Request $request)
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

            $searchResult = Region::with('country')->orderBy($sort_by, $sorting_method)->paginate($paging_size);

            $data['searchResult'] = $searchResult;

            return $request->wantsJson() ? new JsonResponse($searchResult) : Inertia::render('CMS/Region/ManageRegion', $data);

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
            $this->authorize('create', new Region);
            $countries = DB::table('countries')->pluck('name', 'id');
            $data['countries'] = $countries;
            return Inertia::render('CMS/Region/CreateRegion', $data);
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
     * Shop a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    protected function createPost(RegionRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->authorize('create', new Region);
            $region = $request->all();
            Region::create($region);
            DB::commit();
            return redirect()->route('region-management-page');
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
     * @param \App\Models\Region $events
     * @return \Inertia\Response
     */
    protected function editGet($region_id)
    {
        try {
            $region = Region::find($region_id);
            $this->authorize('update', $region);
            $data['region'] = $region;
            $countries = DB::table('countries')->pluck('name', 'id');
            $data['countries'] = $countries;
            return Inertia::render('CMS/Region/EditRegion', $data);
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
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Region $region
     * @return \Illuminate\Http\Response
     */
    protected function editPost(RegionRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $region = Region::find($id);
            $this->authorize('update', $region);
            if ($region != null) {
                $region->update($request->all());
            } else {
                return redirect()->route('region-management-page');
            }
            DB::commit();
            return redirect()->route('region-management-page');
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
     * @param \App\Models\Region $region
     * @return \Illuminate\Http\Response
     */
    protected function delete(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $region = Region::find($id);
            $this->authorize('forceDelete', $region);
            if ($region != null) {
                $region->delete();
                DB::commit();
            } else {
                return back()->withErrors(['errorMessage' => getContentUnpublishedNotificationMessage()]);
            }
            return redirect()->route('region-management-page');
        } catch (\Throwable $ex) {
            DB::rollback();
            logError($ex);
            if ($ex instanceof AuthorizationException) {
                abort(403, getUnAuthorizedAccessMessage());
            }
            return back()->withErrors(['errorMessage' => getGeneralAdminErrorMessage()]);
        }
    }

    protected function getRegions(Request $request)
    {
        $langId = getSessionLanguageShortCode();
        if ($langId == 'en' || $langId == 'EN') {
            $regions = Region::orderBy('name', 'DESC')->distinct()->pluck('name', 'id');
        } else {
            $regions = Region::orderBy('name_lan', 'DESC')->distinct()->pluck('name_lan', 'id');
        }
        return response($regions);
    }

    protected function getRegionsByCountry(Request $request)
    {
        $langId = getSessionLanguageShortCode();
        if ($langId == 'en' || $langId == 'EN') {
            $regions = Region::where('country_id', $request->get('country'))->orderBy('name', 'DESC')->distinct()->pluck('name', 'id');
        } else {
            $regions = Region::where('country_id', $request->get('country'))->orderBy('name_lan', 'DESC')->distinct()->pluck('name_lan', 'id');
        }
        return response($regions);
    }

}
