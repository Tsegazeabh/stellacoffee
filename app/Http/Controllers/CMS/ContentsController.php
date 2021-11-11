<?php

namespace App\Http\Controllers\CMS;

use App\Events\ContentVisited;
use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ContentsController extends Controller
{
    function __construct()
    {
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function publish(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $content = Content::find($id);
            $this->authorize('publish', $content);
            if ($content != null) {
                $content->published_at = now();
                $content->is_published = true;
                $content->published_by = Auth::user()->getAuthIdentifier();
                $content->update();
                DB::commit();
                return response( getContentPublishedNotificationMessage(), 200);
            } else {
                return response('We can not find a content with the specified id', 404);
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

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function unpublish(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $content = Content::find($id);
            $this->authorize('unpublish', $content);
            if ($content != null) {
                $content->published_at = null;
                $content->is_published = false;
                $content->published_by = null;
                $content->update();
                DB::commit();
                return response(getContentUnpublishedNotificationMessage(), 200);
            } else {
                return response('We can not find a content with the specified id', 404);
            }

        } catch (\Throwable $ex) {
            DB::rollback();
            logError($ex);
            if ($ex instanceof AuthorizationException) {
                abort(403, getUnAuthorizedAccessMessage());
            }
            return  new JsonResponse(getGeneralAdminErrorMessage(), 503);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function archive(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $content = Content::find($id);
            $this->authorize('delete', $content);
            if ($content != null) {
                $content->delete();
                DB::commit();
                return response(getContentArchivedNotificationMessage(), 200);
            } else {
                return response('We can not find a content with the specified id', 404);
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

    protected function restore(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $content = Content::onlyTrashed()->where('id', $id)->first();
            $this->authorize('restore', $content);
            if ($content != null) {
                $content->restore();
                DB::commit();
                return response('Content restored successfully', 200);
            } else {
                return response('We can not find a content with the specified id', 404);
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

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function delete(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $content = Content::withTrashed()->with('contentable')->find($id);
            $this->authorize('forceDelete', $content);
            if ($content != null) {
                $content->contentable->delete();
                $content->forceDelete();
                DB::commit();
                return response(getContentDeletedNotificationMessage(), 200);
            } else {
                return response('We can not find a content with the specified id', 404);
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

    /**
     * @param Request $request
     * @param $content_id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    protected function getRelatedContents(Request $request, $content_id)
    {
        try {
            $page = $request->get('page');
            $langId = getSessionLanguageId();
            $tags = $request->get('tags');
            $related_contents = Content::ofRelated($tags, $content_id)
                ->ofLanguage($langId)
                ->with('contentable')
                ->withCount('content_hits')
                ->paginate(getRelatedContentsPagingSize());
            return response($related_contents, 200);
        } catch (\Throwable $ex) {
            logError($ex);
            return response(getGeneralAdminErrorMessage(), 503);
        }
    }

    /**
     * @param Request $request
     * @param $type
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|\Inertia\Response
     */
    protected function getContents(Request $request, $type)
    {
        try {
            $langId = getSessionLanguageId();
            $contentable_type = getModelName($type);
            $result = Content::publishedWithoutArchived()
                ->ofType($contentable_type)
                ->ofLanguage($langId)
                ->with('contentable')
                ->withCount('content_hits')
                ->orderBy('published_at', 'DESC')
                ->paginate(getDefaultPagingSize());
            Log::info($result);
            if ($result->total() > 0) {
                event(new ContentVisited($result->items()[0], $request));
            }
            $data['result'] = $result;
            return Inertia::render(getContentIndexPageComponentName($contentable_type), $data);
        } catch (\Throwable $ex) {
            logError($ex);
            if ($ex instanceof NotFoundHttpException) {
                abort(404);
            }
            return Inertia::render('Errors/UnhandledException');
        }
    }

    protected function getPopularContents(Request $request, $limit)
    {
        try {
            $langId = getSessionLanguageId();
            $popularContents = Content::publishedWithoutArchived()
                ->with('contentable')
                ->ofLanguage($langId)
                ->ofPopular($limit)
                ->get();
            return new JsonResponse($popularContents);
        } catch (\Throwable $ex) {
            logError($ex);
            return response(getGeneralAdminErrorMessage(), 503);
        }
    }

    protected function searchContents(Request $request)
    {
        try {
            $result =
                Content::with('contentable')
                    ->withTrashed()
                    ->ofLanguage(getSessionLanguageId())
                    ->published()
                    ->siteSearch($request->get('keyword'))
                    ->paginate(getDefaultPagingSize());

            $data['result'] = $result;
            return Inertia::render('Public/SearchResult', $data);

        } catch (\Throwable $ex) {
            logError($ex);
            if ($ex instanceof NotFoundHttpException) {
                abort(404);
            }
            return Inertia::render('Errors/UnhandledException');
        }
    }
}
