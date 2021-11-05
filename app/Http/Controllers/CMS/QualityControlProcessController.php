<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\CMS\QualityControlProcessRequest;
use App\Models\Content;
use App\Models\Locale;
use App\Models\QualityControlProcess;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class QualityControlProcessController extends Controller
{

    function __construct()
    {
    }

    /**
     * @param Request $request
     * @return JsonResponse|\Illuminate\Http\RedirectResponse|\Inertia\Response
     */
    protected function manageQualityControlProcess(Request $request)
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
                $query->where('contentable_type', QualityControlProcess::class);
            })->orderBy($sort_by, $sorting_method)->paginate($paging_size);

            $data['searchResult'] = $searchResult;

            return Inertia::render('CMS/QualityControlProcess/ManageQualityControlProcess', $data);

        } catch (\Throwable $ex) {
            report($ex);
            if ($ex instanceof NotFound) {
                abort(404);
            }
            return abort(503);
        }
    }

    protected function fetchQualityControlProcess(Request $request)
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
                        ->whereHasMorph('contentable', [QualityControlProcess::class])
                        ->withTrashed()
                        ->unPublished()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [QualityControlProcess::class])
                        ->sortBy($sortingColumn, $sortingDirection, QualityControlProcess::class)
                        ->paginate($pageSize);
                    break;
                case 2: //published
                    $result = Content::with(['contentable', 'tags'])
                        ->whereHasMorph('contentable', [QualityControlProcess::class])
                        ->withTrashed()
                        ->publishedWithoutArchived()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [QualityControlProcess::class])
                        ->sortBy($sortingColumn, $sortingDirection, QualityControlProcess::class)
                        ->paginate($pageSize);
                    break;
                case 3: //archived
                    $result = Content::with(['contentable', 'tags'])
                        ->whereHasMorph('contentable', [QualityControlProcess::class])
                        ->withTrashed()
                        ->archived()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [QualityControlProcess::class])
                        ->sortBy($sortingColumn, $sortingDirection, QualityControlProcess::class)
                        ->paginate($pageSize);
                    break;
                default: //any
                    $result = Content::with(['contentable', 'tags'])
                        ->whereHasMorph('contentable', [QualityControlProcess::class])
                        ->withTrashed()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [QualityControlProcess::class])
                        ->sortBy($sortingColumn, $sortingDirection, QualityControlProcess::class)
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
            $this->authorize('create', new QualityControlProcess);
            return Inertia::render('CMS/QualityControlProcess/CreateQualityControlProcess');
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
     * @param CreateQualityControlProcess $request
     * @return JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function createPost(QualityControlProcessRequest $request)
    {
        DB::beginTransaction();
        try {
            $locale = Locale::where('short_code', getSessionLanguageShortCode())->first();
            if ($locale != null) {
                $content = array('locale_id' => $locale->id);
                $quality_control_process = Arr::except($request->all(), ['tags', 'xcsrf']);
                $quality_control_process = QualityControlProcess::create($quality_control_process);
                $this->authorize('create', $quality_control_process);
                $content = $quality_control_process->content()->create($content);
                $tags = $request->get('tags');
                $tags = collect($tags)->map(function ($tag) {
                    return $tag['id'];
                });
                $content->tags()->sync($tags);
                DB::commit();
            }
            return redirect()->route('quality-control-process-management-page');

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
     * @param $quality_control_process_id
     * @return \Inertia\Response
     */
    protected function editGet($quality_control_process_id)
    {
        try {
            $quality_control_process = QualityControlProcess::with(['content', 'content.tags'])->find($quality_control_process_id);
            $this->authorize('update', $quality_control_process);
            $data['quality_control_process'] = $quality_control_process;
            return Inertia::render('CMS/QualityControlProcess/EditQualityControlProcess', $data);
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
     * @param $quality_control_process_id
     * @param Request $request
     * @return JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function editPost($quality_control_process_id, QualityControlProcessRequest $request)
    {
        DB::beginTransaction();
        try {
            $quality_control_process = QualityControlProcess::with('content')->find($quality_control_process_id);
            $this->authorize('update', $quality_control_process);
            if ($quality_control_process != null) {
                $quality_control_process->update(
                    Arr::except($request->all(), ['tags', 'csrf'])
                );
                $tags = $request->get('tags');
                $tags = collect($tags)->map(function ($tag) {
                    return $tag['id'];
                });
                $quality_control_process->content->tags()->sync($tags);
                DB::commit();
                return redirect()->route('quality-control-process-management-page');
            } else {
                return bacK()->withErrors(['errorMessage'=> 'We can not find product control process with the specified id!']);
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
    protected function getLatestQualityControlProcess(Request $request)
    {
        try {
            $langId = getSessionLanguageId();
            $latestQualityControlProcess = Content::with('contentable')->whereHas('contentable', function ($query) {
                $query->where('contentable_type', QualityControlProcess::class);
            })
                ->ofLanguage($langId)
                ->publishedWithoutArchived()
                ->orderBy('published_at', 'DESC')
                ->take(4)
                ->get();

            return response($latestQualityControlProcess);

        } catch (\Throwable $ex) {
            logError($ex);
            return new JsonResponse(getGeneralAdminErrorMessage(), 503);
        }
    }

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
                $query->where('contentable_type', QualityControlProcess::class);
            })->find($contentId);

            $data['content'] = $content;
            return Inertia::render('Public/QualityControlProcess/QualityControlProcessDetail', $data);

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
                    $query->where('contentable_type', QualityControlProcess::class);
                })->find($contentId);
            if (!empty($content)) {
                $data['content'] = $content;
                return Inertia::render('Public/QualityControlProcess/QualityControlProcessDetail', $data);
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
