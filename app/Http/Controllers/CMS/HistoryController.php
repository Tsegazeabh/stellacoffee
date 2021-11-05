<?php

namespace App\Http\Controllers\CMS;

use App\Events\ContentVisited;
use App\Http\Controllers\Controller;
use App\Http\Requests\CMS\HistoryRequest;
use App\Models\Content;
use App\Models\History;
use App\Models\Locale;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class HistoryController extends Controller
{
    function __construct()
    {
    }

    /**
     * @param Request $request
     * @return JsonResponse|\Illuminate\Http\RedirectResponse|\Inertia\Response
     */
    protected function manageHistory(Request $request)
    {
        try {
            $paging_size = getDefaultPagingSize();
            $data['pagingSize'] = $paging_size;
            return Inertia::render('CMS/History/ManageHistory', $data);
        } catch (\Throwable $ex) {
            report($ex);
            return back()->with('errorMessage', getGeneralAdminErrorMessage());
        }
    }

    protected function fetchHistory(Request $request)
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
                        ->whereHasMorph('contentable', [History::class])
                        ->withTrashed()
                        ->unPublished()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [History::class])
                        ->sortBy($sortingColumn, $sortingDirection, History::class)
                        ->paginate($pageSize);
                    break;
                case 2: //published
                    $result = Content::with(['contentable', 'tags'])
                        ->whereHasMorph('contentable', [History::class])
                        ->withTrashed()
                        ->publishedWithoutArchived()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [History::class])
                        ->sortBy($sortingColumn, $sortingDirection, History::class)
                        ->paginate($pageSize);
                    break;
                case 3: //archived
                    $result = Content::with(['contentable', 'tags'])
                        ->whereHasMorph('contentable', [History::class])
                        ->withTrashed()
                        ->archived()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [History::class])
                        ->sortBy($sortingColumn, $sortingDirection, History::class)
                        ->paginate($pageSize);
                    break;
                default: //any
                    $result = Content::with(['contentable', 'tags'])
                        ->whereHasMorph('contentable', [History::class])
                        ->withTrashed()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [History::class])
                        ->sortBy($sortingColumn, $sortingDirection, History::class)
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
            $this->authorize('create', new History);
            return Inertia::render('CMS/History/CreateHistory');
        } catch (AuthorizationException $ex) {
            abort(403);
        } catch (\Exception $ex) {
            logError($ex);
            if ($ex instanceof NotFoundHttpException) {
                abort(404);
            } else if ($ex instanceof NotFound) {
                abort(404);
            }
            return abort(503);
        }
    }

    /**
     * @param CreateHistory $request
     * @return JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function createPost(HistoryRequest $request)
    {
        DB::beginTransaction();
        try {

            $locale = Locale::where('short_code', getSessionLanguageShortCode())->first();
            if ($locale != null) {
                $content = array('locale_id' => $locale->id);
                $history = Arr::except($request->all(), ['tags', 'xcsrf']);
                $history = History::create($history);
                $this->authorize('create', $history);

                $content = $history->content()->create($content);
                $tags = $request->get('tags');
                $tags = collect($tags)->map(function ($tag) {
                    return $tag['id'];
                });
                $content->tags()->sync($tags);
                DB::commit();
            }
            return redirect()->route('history-management-page');

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
     * @param $history_id
     * @return \Inertia\Response
     */
    protected function editGet($history_id)
    {
        try {
            $history = History::with(['content', 'content.tags'])->find($history_id);
            $this->authorize('update', $history);
            $data['history'] = $history;
            return Inertia::render('CMS/History/EditHistory', $data);
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
     * @param $history_id
     * @param Request $request
     * @return JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function editPost($history_id, HistoryRequest $request)
    {
        DB::beginTransaction();
        try {
            $history = History::with('content')->find($history_id);
            $this->authorize('update', $history);
            if ($history != null) {
                $history->update(
                    Arr::except($request->all(), ['tags', 'csrf'])
                );

                $tags = $request->get('tags');
                $tags = collect($tags)->map(function ($tag) {
                    return $tag['id'];
                });
                $history->content->tags()->sync($tags);
                DB::commit();
                return redirect()->route('history-management-page');
            } else {
                return back()->withErrors('errorMessage', 'We can not find history with the specified id!');
            }
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
     * @return \Illuminate\Contracts\Routing\ResponseFactory|JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    protected function getLatestHistory(Request $request)
    {
        try {
            $latestHistory =
                Content::with('contentable')
                    ->whereHasMorph('contentable', [History::class])
                    ->publishedWithoutArchived()
                    ->ofLanguage(getSessionLanguageId())
                    ->sortBy('from_date', 'DESC', History::class)
                    ->get();
            return response($latestHistory);
        } catch (\Throwable $ex) {
            logError($ex);
            return new JsonResponse(getGeneralAdminErrorMessage(), 503);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    protected function getAllHistory(Request $request)
    {
        try {
            $history =
                Content::with('contentable')
                    ->where('contentable_type', History::class)
                    ->whereHasMorph('contentable', [History::class])
                    ->publishedWithoutArchived()
                    ->ofLanguage(getSessionLanguageId())
                    ->sortBy('from_date', 'DESC', History::class)
                    ->get();
            $data['history'] = $history;
            return Inertia::render('Public/History/HistoryIndex', $data);
        } catch (\Throwable $ex) {
            logError($ex);
            if ($ex instanceof NotFound) {
                abort(404);
            }
            return abort(503);
        }
    }

    /**
     * @param Request $request
     * @param $contentId
     * @return JsonResponse|\Illuminate\Http\RedirectResponse|\Inertia\Response
     */
    protected function preview($contentId)
    {
        try {
            $content = Content::withTrashed()->with('contentable', 'tags')->whereHas('contentable', function ($query) {
                $query->where('contentable_type', History::class);
            })->find($contentId);

            $data['content'] = $content;
            return Inertia::render('Public/History/HistoryDetail', $data);

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
        try {
            $content = Content::withTrashed()
                ->published()
                ->ofLanguage(getSessionLanguageId())
                ->with('contentable', 'tags')
                ->withCount('content_hits')
                ->whereHas('contentable', function ($query) {
                    $query->where('contentable_type', History::class);
                })->find($contentId);
            if (!empty($content)) {
                event(new ContentVisited($content, $request));
                $data['content'] = $content;
                return Inertia::render('Public/History/HistoryDetail', $data);
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
