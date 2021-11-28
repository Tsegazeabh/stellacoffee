<?php

namespace App\Http\Controllers\CMS;

use App\Events\ContentVisited;
use App\Http\Controllers\Controller;
use App\Http\Requests\CMS\CreateNews;
use App\Http\Requests\CMS\NewsFormRequest;
use App\Models\Content;
use App\Models\Locale;
use App\Models\News;
use App\Models\User;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Event;

class NewsController extends Controller
{

    function __construct()
    {
    }

    /**
     * @return Response
     */
    protected function createGet()
    {
        try {
            $this->authorize('create', new News);
            return Inertia::render('CMS/News/CreateNews');
        } catch (AuthorizationException $ex) {
            abort(403);
        } catch (\Exception $ex) {
            logError($ex);
            if ($ex instanceof AuthorizationException) {
                abort(403, getUnAuthorizedAccessMessage());
            } else if ($ex instanceof NotFoundHttpException) {
                abort(404);
            }
            return Inertia::render('Errors/UnhandledException');
        }
    }

    /**
     * @param NewsFormRequest $request
     * @return JsonResponse|RedirectResponse
     */
    protected function createPost(NewsFormRequest $request)
    {
        DB::beginTransaction();
        try {
            $locale = Locale::where('short_code', getSessionLanguageShortCode())->first();
            if ($locale != null) {
                $content = array('locale_id' => $locale->id);
                $news = Arr::except($request->all(), ['tags', 'xcsrf']);
                $news = News::create($news);
                $this->authorize('create', $news);
                $content = $news->content()->create($content);

                $tags = $request->get('tags');
                $tags = collect($tags)->map(function ($tag) {
                    return $tag['id'];
                });
                $content->tags()->sync($tags);
                DB::commit();
            }
            return redirect()->route('news-management-page', ['successMessage' => 'News created successfully']);

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
     * @return JsonResponse|RedirectResponse|Response
     */
    protected function manageNews(Request $request)
    {
        try {
            $data['pagingSize'] = getDefaultPagingSize();
            return Inertia::render('CMS/News/ManageNews', $data);
        } catch (\Throwable $ex) {
            report($ex);
            return back()->withErrors(['errorMessage' => getGeneralAdminErrorMessage()]);
        }
    }

    protected function fetchNews(Request $request)
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
                        ->whereHasMorph('contentable', [News::class])
                        ->withTrashed()
                        ->unPublished()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [News::class])
                        ->sortBy($sortingColumn, $sortingDirection, News::class)
                        ->paginate($pageSize);
                    break;
                case 2: //published
                    $result = Content::with(['contentable', 'tags'])
                        ->whereHasMorph('contentable', [News::class])
                        ->withTrashed()
                        ->publishedWithoutArchived()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [News::class])
                        ->sortBy($sortingColumn, $sortingDirection, News::class)
                        ->paginate($pageSize);
                    break;
                case 3: //archived
                    $result = Content::with(['contentable', 'tags'])
                        ->whereHasMorph('contentable', [News::class])
                        ->withTrashed()
                        ->archived()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [News::class])
                        ->sortBy($sortingColumn, $sortingDirection, News::class)
                        ->paginate($pageSize);
                    break;
                default: //any
                    $result = Content::with(['contentable', 'tags'])
                        ->whereHasMorph('contentable', [News::class])
                        ->withTrashed()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [News::class])
                        ->sortBy($sortingColumn, $sortingDirection, News::class)
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
     * @param $news_id
     * @return Response
     */
    protected function editGet($news_id)
    {
        try {
            $news = News::with(['content', 'content.tags'])->find($news_id);
            $this->authorize('update', $news);
            $data['news'] = $news;
            return Inertia::render('CMS/News/EditNews', $data);
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
     * @param $news_id
     * @param NewsFormRequest $request
     * @return JsonResponse|RedirectResponse
     */
    protected function editPost($news_id, NewsFormRequest $request)
    {
        DB::beginTransaction();
        try {
            $news = News::with('content')->find($news_id);
            $this->authorize('update', $news);

            if ($news != null) {
                $news->update(
                    Arr::except($request->all(), ['tags', 'csrf'])
                );

                $tags = $request->get('tags');
                $tags = collect($tags)->map(function ($tag) {
                    return $tag['id'];
                });
                $news->content->tags()->sync($tags);
                DB::commit();
                return redirect()->route('news-management-page', ['successMessage' => 'News updated successfully']);
            } else {
                return back()->withErrors(['errorMessage' => 'We can not find news with the specified id!']);
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
     * @return \Illuminate\Contracts\Routing\ResponseFactory|JsonResponse|RedirectResponse|\Illuminate\Http\Response
     */
    protected function getLatestNews(Request $request)
    {
        try {
            $langId = getSessionLanguageId();
            $latestNews = Content::with('contentable')
                ->publishedWithoutArchived()
                ->withCount('content_hits')
                ->whereHas('contentable', function ($query) {
                    $query->where('contentable_type', News::class);
                })
                ->ofLanguage($langId)
                ->orderBy('published_at', 'DESC')
                ->take(4)
                ->get();

            return response($latestNews);

        } catch (\Throwable $ex) {
            logError($ex);
            return response(getGeneralAdminErrorMessage(), 503);
        }
    }

    /**
     * @param Request $request
     * @param $contentId
     * @return JsonResponse|RedirectResponse|Response
     */
    protected function preview($contentId)
    {
        try {
            $langId = getSessionLanguageId();
            $content = Content::withTrashed()
                ->ofLanguage($langId)
                ->with('contentable', 'tags')
                ->withCount('content_hits')
                ->whereHas('contentable', function ($query) {
                    $query->where('contentable_type', News::class);
                })->find($contentId);

            $data['content'] = $content;
            return Inertia::render('Public/News/NewsDetail', $data);

        } catch (\Throwable $ex) {
            logError($ex);
            return back()->withErrors(['errorMessage'=> getGeneralAdminErrorMessage()]);
        }
    }

    /**
     * @param Request $request
     * @param $contentId
     * @return JsonResponse|RedirectResponse|Response
     */
    protected function getDetail(Request $request, $contentId)
    {
        try {
            $langId = getSessionLanguageId();
            $content = Content::published()
                ->withTrashed()
                ->ofLanguage($langId)
                ->with('contentable', 'tags')
                ->withCount('content_hits')
                ->whereHas('contentable', function ($query) {
                    $query->where('contentable_type', News::class);
                })->find($contentId);

            if (!empty($content)) {
                event(new ContentVisited($content, $request));
                $data['content'] = $content;
                return Inertia::render('Public/News/NewsDetail', $data);
            } else {
                return abort(404);
            }
        } catch (\Throwable $ex) {
            logError($ex);
            if ($ex instanceof NotFoundHttpException) {
                abort(404);
            }
            return Inertia::render('Errors/UnhandledException');
        }
    }
}
