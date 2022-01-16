<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\CMS\CountryRequest;
use App\Models\Country;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CountryController extends Controller
{
    function __construct()
    {
    }
    /**
     * Display a listing of the resource management such as create, edit, delete, and show.
     *
     * @return \Inertia\Response
     */
    protected function manageCountry(Request $request)
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

            $searchResult = Country::orderBy($sort_by, $sorting_method)->paginate($paging_size);

            $data['searchResult'] = $searchResult;

            return $request->wantsJson() ? new JsonResponse($searchResult) : Inertia::render('CMS/Country/ManageCountry', $data);

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
            $this->authorize('create', new Country);
            return Inertia::render('CMS/Country/CreateCountry');
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function createPost(CountryRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->authorize('create', new Country);
            $country = $request->all();
            Country::create($country);
            DB::commit();
            return redirect()->route('country-management-page');
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
     * @param  \App\Models\Country  $events
     * @return \Inertia\Response
     */
    protected function editGet($country_id)
    {
        try {
            $country = Country::find($country_id);
            $this->authorize('update', $country);
            $data['country'] = $country;
            return Inertia::render('CMS/Country/EditCountry', $data);
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
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    protected function editPost(CountryRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $country = Country::find($id);
            $this->authorize('update', $country);
            if ($country != null) {
                $country->update($request->all());
            }
            else {
                return $request->wantsJson() ? new JsonResponse('Country is updated successfully') : redirect()->route('country-management-page', ['successMessage' => 'Country is updated successfully']);
            }
            DB::commit();
            return redirect()->route('country-management-page');
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
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    protected function delete(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $country = Country::find($id);
            $this->authorize('forceDelete', $country);
            if ($country != null) {
                $country->delete();
                DB::commit();
            } else {
                return $request->wantsJson() ? new JsonResponse(getContentUnpublishedNotificationMessage()) : back()->with('successMessage', getContentUnpublishedNotificationMessage());
            }
            return $request->wantsJson() ? new JsonResponse('We can not find a country with the specified id', 404) : back()->with('errorMessage', 'We can not find a country with the specified id!');
        } catch (\Throwable $ex) {
            DB::rollback();
            logError($ex);
            if ($ex instanceof AuthorizationException) {
                abort(403, getUnAuthorizedAccessMessage());
            }
            return $request->wantsJson() ? new JsonResponse(getGeneralAdminErrorMessage(), 503) : back()->with('errorMessage', getGeneralAdminErrorMessage());
        }
    }

    protected function  getCountries(Request $request)
    {
        $langId = getSessionLanguageShortCode();
        if($langId =='am' || $langId =='AM')
        {
            $countries = Country::orderBy('name_am', 'DESC')->distinct()->pluck('name_am','id');
        }
        elseif($langId =='fr' || $langId =='FR')
        {
            $countries = Country::orderBy('name_fr', 'DESC')->distinct()->pluck('name_fr','id');
        }
        elseif($langId =='it' || $langId =='IT')
        {
            $countries = Country::orderBy('name_it', 'DESC')->distinct()->pluck('name_it','id');
        }
        else {
            $countries = Country::orderBy('name', 'DESC')->distinct()->pluck('name','id');
        }
        return response($countries);
    }
    protected function getAllCountries(Request $request)
    {
        $langId = getSessionLanguageShortCode();
        if($langId =='am' || $langId =='AM')
        {
            $countries = Country::orderBy('name_am', 'DESC')->distinct()->pluck('name_am','id');
        }
        elseif($langId =='fr' || $langId =='FR')
        {
            $countries = Country::orderBy('name_fr', 'DESC')->distinct()->pluck('name_fr','id');
        }
        elseif($langId =='it' || $langId =='IT')
        {
            $countries = Country::orderBy('name_it', 'DESC')->distinct()->pluck('name_it','id');
        }
        else {
            $countries = Country::orderBy('name', 'DESC')->distinct()->pluck('name','id');
        }
        return response($countries);
    }
}
