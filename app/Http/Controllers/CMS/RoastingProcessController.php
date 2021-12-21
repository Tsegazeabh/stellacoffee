<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\CMS\RoastingProcessRequest;
use App\Models\Content;
use App\Models\Locale;
use App\Models\RoastingProcess;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RoastingProcessController extends Controller
{
    function __construct()
    {
    }

    /**
     * @param Request $request
     * @return JsonResponse|\Illuminate\Http\RedirectResponse|\Inertia\Response
     */
    protected function manageRoastingProcess(Request $request)
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
                $query->where('contentable_type', RoastingProcess::class);
            })->orderBy($sort_by, $sorting_method)->paginate($paging_size);

            $data['searchResult'] = $searchResult;

            return Inertia::render('CMS/RoastingProcess/ManageRoastingProcess', $data);

        } catch (\Throwable $ex) {
            report($ex);
            if ($ex instanceof NotFound) {
                abort(404);
            }
            return abort(503);
        }
    }

    protected function fetchRoastingProcess(Request $request)
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
                        ->whereHasMorph('contentable', [RoastingProcess::class])
                        ->withTrashed()
                        ->unPublished()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [RoastingProcess::class])
                        ->sortBy($sortingColumn, $sortingDirection, RoastingProcess::class)
                        ->paginate($pageSize);
                    break;
                case 2: //published
                    $result = Content::with(['contentable', 'tags'])
                        ->whereHasMorph('contentable', [RoastingProcess::class])
                        ->withTrashed()
                        ->publishedWithoutArchived()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [RoastingProcess::class])
                        ->sortBy($sortingColumn, $sortingDirection, RoastingProcess::class)
                        ->paginate($pageSize);
                    break;
                case 3: //archived
                    $result = Content::with(['contentable', 'tags'])
                        ->whereHasMorph('contentable', [RoastingProcess::class])
                        ->withTrashed()
                        ->archived()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [RoastingProcess::class])
                        ->sortBy($sortingColumn, $sortingDirection, RoastingProcess::class)
                        ->paginate($pageSize);
                    break;
                default: //any
                    $result = Content::with(['contentable', 'tags'])
                        ->whereHasMorph('contentable', [RoastingProcess::class])
                        ->withTrashed()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [RoastingProcess::class])
                        ->sortBy($sortingColumn, $sortingDirection, RoastingProcess::class)
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
            $this->authorize('create', new RoastingProcess);
            return Inertia::render('CMS/RoastingProcess/CreateRoastingProcess');
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
     * @param CreateRoastingProcess $request
     * @return JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function createPost(RoastingProcessRequest $request)
    {
        DB::beginTransaction();
        try {
            $locale = Locale::where('short_code', getSessionLanguageShortCode())->first();
            if ($locale != null) {
                $content = array('locale_id' => $locale->id);
                $roasting_process = Arr::except($request->all(), ['tags', 'xcsrf']);
                $roasting_process = RoastingProcess::create($roasting_process);
                $this->authorize('create', $roasting_process);
                $content = $roasting_process->content()->create($content);
                $tags = $request->get('tags');
                $tags = collect($tags)->map(function ($tag) {
                    return $tag['id'];
                });
                $content->tags()->sync($tags);
                DB::commit();
            }
            return redirect()->route('roasting-process-management-page');

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
     * @param $roasting_process_id
     * @return \Inertia\Response
     */
    protected function editGet($roasting_process_id)
    {
        try {
            $roasting_process = RoastingProcess::with(['content', 'content.tags'])->find($roasting_process_id);
            $this->authorize('update', $roasting_process);
            $data['roasting_process'] = $roasting_process;
            return Inertia::render('CMS/RoastingProcess/EditRoastingProcess', $data);
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
     * @param $roasting_process_id
     * @param Request $request
     * @return JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function editPost($roasting_process_id, RoastingProcessRequest $request)
    {
        DB::beginTransaction();
        try {
            $roasting_process = RoastingProcess::with('content')->find($roasting_process_id);
            $this->authorize('update', $roasting_process);
            if ($roasting_process != null) {
                $roasting_process->update(
                    Arr::except($request->all(), ['tags', 'csrf'])
                );
                $tags = $request->get('tags');
                $tags = collect($tags)->map(function ($tag) {
                    return $tag['id'];
                });
                $roasting_process->content->tags()->sync($tags);
                DB::commit();
                return redirect()->route('roasting-process-management-page');
            } else {
                return bacK()->withErrors(['errorMessage'=> 'We can not find roasting process with the specified id!']);
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
    protected function getLatestRoastingProcess(Request $request)
    {
        try {
            $langId = getSessionLanguageId();
//            $pageSize = $request->get('pageSize', getDefaultPagingSize());
            $latestRoastingProcess = Content::with('contentable')->whereHas('contentable', function ($query) {
                $query->where('contentable_type', RoastingProcess::class);
            })
                ->ofLanguage($langId)
                ->publishedWithoutArchived()
                ->orderBy('published_at', 'DESC')
                ->take(1)
                ->get();
            return response($latestRoastingProcess);

        } catch (\Throwable $ex) {
            logError($ex);
            return new JsonResponse(getGeneralAdminErrorMessage(), 503);
        }
    }
//    protected function getTabRoastingProcess(Request $request)
//    {
//        try {
//            $langId = getSessionLanguageId();
//            $latestRoastingProcess = Content::with('contentable')->whereHas('contentable', function ($query) {
//                $query->where('contentable_type', RoastingProcess::class);
//            })
//                ->ofLanguage($langId)
//                ->publishedWithoutArchived()
//                ->orderBy('published_at', 'DESC')
//                ->take(1)
//                ->get();
//            return response($latestRoastingProcess);
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
                $query->where('contentable_type', RoastingProcess::class);
            })->find($contentId);

            $data['content'] = $content;
            return Inertia::render('Public/RoastingProcess/RoastingProcessDetail', $data);

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
                    $query->where('contentable_type', RoastingProcess::class);
                })->find($contentId);
            if (!empty($content)) {
                $data['content'] = $content;
                return Inertia::render('Public/RoastingProcess/RoastingProcessDetail', $data);
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
