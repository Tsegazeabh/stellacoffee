<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\CMS\RoastingServiceRequest;
use App\Models\Content;
use App\Models\Locale;
use App\Models\RoastingService;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RoastingServiceController extends Controller
{
    function __construct()
    {
    }

    /**
     * @param Request $request
     * @return JsonResponse|\Illuminate\Http\RedirectResponse|\Inertia\Response
     */
    protected function manageRoastingService(Request $request)
    {
        try {
            $content_status = $request->get('content_status');
            $sort_by = $request->get('current_sorting_col', getDefaultSortingColumn());

            if (mb_strlen($sort_by) == 0) {
                $sort_by = getDefaultSortingColumn();
            }

            $sorting_method = $request->get('sorting_method', getDefaultSortingMethod());
            if (mb_strlen($sorting_method) == 0) {
                $sorting_method = getDefaultSortingMethod();
            }

            $paging_size = getDefaultPagingSize();

            $searchResult = Content::withTrashed()->with('contentable', 'tags')->whereHas('contentable', function ($query) {
                $query->where('contentable_type', RoastingService::class);
            })->orderBy($sort_by, $sorting_method)->paginate($paging_size);

            $data['searchResult'] = $searchResult;

            return Inertia::render('CMS/RoastingService/ManageRoastingService', $data);

        } catch (\Throwable $ex) {
            report($ex);
            if ($ex instanceof NotFound) {
                abort(404);
            }
            return abort(503);
        }
    }

    protected function fetchRoastingService(Request $request)
    {
        try {
            $langId = getSessionLanguageId();
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
                case 1: // unpublished
                    $result = Content::with(['contentable', 'tags'])
                        ->whereHasMorph('contentable', [RoastingService::class])
                        ->withTrashed()
                        ->unPublished()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [RoastingService::class])
                        ->sortBy($sortingColumn, $sortingDirection, RoastingService::class)
                        ->paginate($pageSize);
                    break;
                case 2: //published
                    $result = Content::with(['contentable', 'tags'])
                        ->whereHasMorph('contentable', [RoastingService::class])
                        ->withTrashed()
                        ->publishedWithoutArchived()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [RoastingService::class])
                        ->sortBy($sortingColumn, $sortingDirection, RoastingService::class)
                        ->paginate($pageSize);
                    break;
                case 3: //archived
                    $result = Content::with(['contentable', 'tags'])
                        ->whereHasMorph('contentable', [RoastingService::class])
                        ->withTrashed()
                        ->archived()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [RoastingService::class])
                        ->sortBy($sortingColumn, $sortingDirection, RoastingService::class)
                        ->paginate($pageSize);
                    break;
                default: //any
                    $result = Content::with(['contentable', 'tags'])
                        ->whereHasMorph('contentable', [RoastingService::class])
                        ->withTrashed()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [RoastingService::class])
                        ->sortBy($sortingColumn, $sortingDirection, RoastingService::class)
                        ->paginate($pageSize);
                    break;
            }
            return new JsonResponse($result);
        } catch (\Throwable $ex) {
            report($ex);
            return new JsonResponse(getGeneralAdminErrorMessage(), 503);
        }
    }
    /**
     * @return \Inertia\Response
     */
    protected function createGet()
    {
        try {
            $this->authorize('create', new RoastingService);
            return Inertia::render('CMS/RoastingService/CreateRoastingService');
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
     * @param CreateRoastingService $request
     * @return JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function createPost(RoastingServiceRequest $request)
    {
        DB::beginTransaction();
        try {
            $locale = Locale::where('short_code', getSessionLanguageShortCode())->first();
            if ($locale != null) {
                $content = array('locale_id' => $locale->id);
                $roasting_service = Arr::except($request->all(), ['tags', 'xcsrf']);
                $roasting_service = RoastingService::create($roasting_service);
                $this->authorize('create', $roasting_service);
                $content = $roasting_service->content()->create($content);
                $tags = $request->get('tags');
                $tags = collect($tags)->map(function ($tag) {
                    return $tag['id'];
                });
                $content->tags()->sync($tags);
                DB::commit();
            }
            return redirect()->route('roasting-service-management-page');

        } catch (\Throwable $ex) {
            DB::rollback();
            logError($ex);
            if ($ex instanceof AuthorizationException) {
                abort(403, getUnAuthorizedAccessMessage());
            }

            else if ($ex instanceof NotFound) {
                abort(404);
            }
            return abort(503);
        }
    }


    /**
     * @param $roasting_service_id
     * @return \Inertia\Response
     */
    protected function editGet($roasting_service_id)
    {
        try {
            $roasting_service = RoastingService::with(['content', 'content.tags'])->find($roasting_service_id);
            $this->authorize('update', $roasting_service);
            $data['roasting_service'] = $roasting_service;
            return Inertia::render('CMS/RoastingService/EditRoastingService', $data);
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
     * @param $roasting_service_id
     * @param Request $request
     * @return JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function editPost($roasting_service_id, RoastingServiceRequest $request)
    {
        DB::beginTransaction();
        try {
            $roasting_service = RoastingService::with('content')->find($roasting_service_id);
            $this->authorize('update', $roasting_service);
            if ($roasting_service != null) {
                $roasting_service->update(
                    Arr::except($request->all(), ['tags', 'csrf'])
                );
                $tags = $request->get('tags');
                $tags = collect($tags)->map(function ($tag) {
                    return $tag['id'];
                });
                $roasting_service->content->tags()->sync($tags);
                DB::commit();
                return redirect()->route('roasting-service-management-page');
            } else {
                return bacK()->withErrors(['errorMessage'=> 'We can not find roasting service with the specified id!']);
            }
        } catch (\Throwable $ex) {
            DB::rollback();
            logError($ex);
            if ($ex instanceof AuthorizationException) {
                abort(403, getUnAuthorizedAccessMessage());
            }
            else if ($ex instanceof NotFound) {
                abort(404);
            }
            return abort(503);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    protected function getLatestRoastingService(Request $request)
    {
        try {
            $langId = getSessionLanguageId();
//            $pageSize = $request->get('pageSize', getDefaultPagingSize());
            $latestRoastingService = Content::with('contentable')->whereHas('contentable', function ($query) {
                $query->where('contentable_type', RoastingService::class);
            })
                ->ofLanguage($langId)
                ->publishedWithoutArchived()
                ->orderBy('published_at', 'DESC')
                ->take(1)
                ->get();
            return response($latestRoastingService);
        } catch (\Throwable $ex) {
            logError($ex);
            return new JsonResponse(getGeneralAdminErrorMessage(), 503);
        }
    }
//    protected function getTabRoastingService(Request $request)
//    {
//        try {
//            $langId = getSessionLanguageId();
//            $latestRoastingService = Content::with('contentable')->whereHas('contentable', function ($query) {
//                $query->where('contentable_type', RoastingService::class);
//            })
//                ->ofLanguage($langId)
//                ->publishedWithoutArchived()
//                ->orderBy('published_at', 'DESC')
//                ->take(1)
//                ->get();
//
//            return response($latestRoastingService);
//
//        } catch (\Throwable $ex) {
//            logError($ex);
//            return new JsonResponse(getGeneralAdminErrorMessage(), 503);
//        }
//    }

    /**
     * @param Request $request
     * @param $contentId
     * @return JsonResponse|\Illuminate\Http\RedirectResponse|\Inertia\Response
     */
    protected function preview($contentId)
    {
        try
        {
            $content = Content::withTrashed()->with('contentable', 'tags')->whereHas('contentable', function ($query) {
                $query->where('contentable_type', RoastingService::class);
            })->find($contentId);

            $data['content'] = $content;
            return Inertia::render('Public/RoastingService/RoastingServiceDetail', $data);

        } catch (\Throwable $ex) {
            logError($ex);
            return back()->with('errorMessage', getGeneralAdminErrorMessage());
        }
    }

    /**
     * @param Request $request
     * @param $contentId
     * @return JsonResponse|\Illuminate\Http\RedirectResponse|\Inertia\Response
     */
    protected function getDetail(Request $request, $contentId)
    {
        try
        {
            $content = Content::withTrashed()
                ->published()
                ->ofLanguage(getSessionLanguageId())
                ->with('contentable', 'tags')
                ->withCount('content_hits')
                ->whereHas('contentable', function ($query) {
                    $query->where('contentable_type', RoastingService::class);
                })->find($contentId);
            if (!empty($content)) {
                $data['content'] = $content;
                return Inertia::render('Public/RoastingService/RoastingServiceDetail', $data);
            }else{
                return abort(404);
            }
        } catch (\Throwable $ex) {
            logError($ex);
            if ($ex instanceof NotFound) {
                abort(404);
            }
            return abort(503);
        }
    }
}
