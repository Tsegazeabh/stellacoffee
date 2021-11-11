<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\CMS\CityRequest;
use App\Models\City;
use App\Models\Locale;
use App\Rules\ValidFileType;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CityController extends Controller
{
    function __construct()
    {
    }

    /**
     * Display a listing of the resource management such as create, edit, delete, and show.
     *
     * @return \Inertia\Response
     */
    protected function manageCity(Request $request)
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

            $searchResult = City::with('region', 'woreda', 'zone')->orderBy($sort_by, $sorting_method)->paginate($paging_size);

            $data['searchResult'] = $searchResult;

            return Inertia::render('CMS/City/ManageCity', $data);

        } catch (\Throwable $ex) {
            report($ex);
            if ($ex instanceof NotFound) {
                abort(404);
            }
            abort(503);
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
            $this->authorize('create', new City);
            $countries = DB::table('countries')->pluck('name', 'id');
            $woredas = DB::table('woredas')->pluck('name', 'id');
            $zones = DB::table('zones')->pluck('name', 'id');
            $data['countries'] = $countries;
            $data['woredas'] = $woredas;
            $data['zones'] = $zones;
            return Inertia::render('CMS/City/CreateCity', $data);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    protected function createPost(CityRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->authorize('create', new City);
            $city = $request->all();
            City::create($city);
            DB::commit();
            return redirect()->route('city-management-page');
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
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\City $events
     * @return \Inertia\Response
     */
    protected function editGet($city_id)
    {
        try {
            $city = City::find($city_id);
            $countries = DB::table('countries')->pluck('name', 'id');
            $woredas = DB::table('woredas')->pluck('name', 'id');
            $zones = DB::table('zones')->pluck('name', 'id');
            $this->authorize('update', $city);
            $data['city'] = $city;
            $data['countries'] = $countries;
            $data['woredas'] = $woredas;
            $data['zones'] = $zones;
            return Inertia::render('CMS/City/EditCity', $data);
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
     * @param \App\Models\City $city
     * @return \Illuminate\Http\Response
     */
    protected function editPost(CityRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $city = City::find($id);
            $this->authorize('update', $city);
            if ($city != null) {
                $city->update($request->all());
            } else {
                return back()->withErrors(['errorMessage' => getResourceNotFoundErrorMessage()]);
            }
            DB::commit();
            return redirect()->route('city-management-page');
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
     * Remove the specified resource from storage.
     *
     * @param \App\Models\City $city
     * @return \Illuminate\Http\Response
     */
    protected function delete(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $city = City::find($id);
            $this->authorize('forceDelete', $city);
            if ($city != null) {
                $city->delete();
                DB::commit();
            } else {
                return back()->withErrors(['errorMessage' => getContentUnpublishedNotificationMessage()]);
            }
            return back()->with('errorMessage', 'We can not find a city with the specified id!');
        } catch (\Throwable $ex) {
            DB::rollback();
            logError($ex);
            if ($ex instanceof AuthorizationException) {
                abort(403, getUnAuthorizedAccessMessage());
            }
            return $request->wantsJson() ? new JsonResponse(getGeneralAdminErrorMessage(), 503) : back()->with('errorMessage', getGeneralAdminErrorMessage());
        }
    }

    protected function getCities(Request $request)
    {
        $langId = getSessionLanguageShortCode();
        if ($langId == 'en' || $langId == 'EN') {
            $cities = City::where('region_id', $request->get('region'))->orderBy('name', 'DESC')->distinct()->pluck('name', 'id');
        } else {
            $cities = City::where('region_id', $request->get('region'))->orderBy('name_lan', 'DESC')->distinct()->pluck('name_lan', 'id');
        }
        return response($cities);
    }

    protected function getAllCities(Request $request)
    {
        $langId = getSessionLanguageShortCode();
        if ($langId == 'en' || $langId == 'EN') {
            $cities = City::orderBy('name', 'DESC')->distinct()->pluck('name', 'id');
        } else {
            $cities = City::orderBy('name_lan', 'DESC')->distinct()->pluck('name_lan', 'id');
        }
        return response($cities);
    }

//    protected function getCitiesByRegion(Request $request)
//    {
//        $langId = getSessionLanguageShortCode();
//        if($langId =='en'){
//            $regions = City::where('region_id', $request->get('region'))->orderBy('name', 'DESC')->distinct()->pluck('name','id');
//        }
//        else{
//            $regions = City::where('region_id', $request->get('region'))->orderBy('name_lan', 'DESC')->distinct()->pluck('name_lan','id');
//        }
//        return response($regions);
//    }
}