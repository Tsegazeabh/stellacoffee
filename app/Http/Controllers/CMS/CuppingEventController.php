<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\CMS\CuppingEventFormRequest;
use App\Models\Content;
use App\Models\CuppingEvent;
use App\Models\Locale;
use Carbon\Carbon;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CuppingEventController extends Controller
{
    public function __construct() { }

    protected function index(Request $request)
    {
        try {
            $content = Content::withTrashed()
                ->publishedWithoutArchived()
                ->ofLanguage(getSessionLanguageId())
                ->with('contentable')
                ->withCount('content_hits')
                ->whereHas('contentable', function ($query) {
                    $query->where('contentable_type', CuppingEvent::class);
                })->paginate(getDefaultPagingSize());
            $data['result'] = $content;
            return Inertia::render('Public/CuppingEvents/CuppingEventsIndex', $data);
        } catch (\Throwable $ex) {
            logError($ex);
            return back()->with('errorMessage', getGeneralAdminErrorMessage());
        }
    }

    protected function preview(Request $request, $contentId)
    {
        try {
            $content = Content::withTrashed()
                ->ofLanguage(getSessionLanguageId())
                ->with('contentable', 'tags')
                ->withCount('content_hits')
                ->whereHas('contentable', function ($query) {
                    $query->where('contentable_type', CuppingEvent::class);
                })->find($contentId);

            if (!empty($content)) {
                $data['content'] = $content;
                return Inertia::render('Public/CuppingEvents/CuppingEventDetail', $data);
            } else {
                return abort(404);
            }
        } catch (\Throwable $ex) {
            logError($ex);
            return back()->with('errorMessage', getGeneralAdminErrorMessage());
        }
    }

    protected function getDetail(Request $request, $contentId)
    {
        try {
            $content = Content::withTrashed()
                ->published()
                ->ofLanguage(getSessionLanguageId())
                ->with('contentable', 'tags')
                ->withCount('content_hits')
                ->whereHas('contentable', function ($query) {
                    $query->where('contentable_type', CuppingEvent::class);
                })->find($contentId);

            if (!empty($content)) {
                $data['content'] = $content;
                return Inertia::render('Public/CuppingEvents/CuppingEventDetail', $data);
            } else {
                return abort(404);
            }
        } catch (\Throwable $ex) {
            logError($ex);
            return back()->with('errorMessage', getGeneralAdminErrorMessage());
        }
    }

    protected function createGet()
    {
        try {
            $this->authorize('create', new CuppingEvent());
            return Inertia::render('CMS/CuppingEvents/CreateCuppingEvent');
        } catch (\Throwable $ex) {
            DB::rollback();
            logError($ex);
            if ($ex instanceof AuthorizationException) {
                abort(403, getUnAuthorizedAccessMessage());
            } else if ($ex instanceof NotFound) {
                abort(404);
            }
            return abort(503);
        }
    }

    protected function createPost(CuppingEventFormRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->authorize('create', new CuppingEvent());
            $locale = Locale::where('short_code', getSessionLanguageShortCode())->first();
            if ($locale != null) {
                $content = array('locale_id' => $locale->id);
                $request['event_date'] = Carbon::createFromFormat('Y-m-d h:i A', $request->get('event_date'));
                $cupping_event = Arr::except($request->all(), ['tags', 'xcsrf']);
                $cupping_event = CuppingEvent::create($cupping_event);
                $content = $cupping_event->content()->create($content);
                $tags = $request->get('tags');
                $tags = collect($tags)->map(function ($tag) {
                    return $tag['id'];
                });
                $content->tags()->sync($tags);
                DB::commit();
                return redirect(route('cupping-events-management-page'));
            } else {
                return back()->withErrors(['language' => 'Locale not found']);
            }
        } catch (\Throwable $ex) {
            logError($ex);
            if ($ex instanceof NotFoundHttpException) {
                abort(404);
            }
            return abort(503);
        }
    }

    protected function editGet($cupping_event_id)
    {
        try {
            $cupping_event = CuppingEvent::with(['content', 'content.tags'])->find($cupping_event_id);
            if (!is_null($cupping_event)) {
                $this->authorize('update', $cupping_event);
                $data['cupping_event'] = $cupping_event;
                return Inertia::render('CMS/CuppingEvents/CuppingEventEditor', $data);
            } else {
                abort(404);
            }
        } catch (\Throwable $ex) {
            DB::rollback();
            logError($ex);
            if ($ex instanceof AuthorizationException) {
                abort(403, getUnAuthorizedAccessMessage());
            } else if ($ex instanceof NotFound) {
                abort(404);
            }
            return abort(503);
        }
    }

    protected function editPost(CuppingEventFormRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $request['event_date'] = Carbon::createFromFormat('Y-m-d h:i A', $request->get('event_date'));

            $cupping_event = CuppingEvent::with('content')->find($id);
            $this->authorize('update', $cupping_event);

            if ($cupping_event != null) {
                $cupping_event->update(
                    Arr::except($request->all(), ['tags', 'csrf'])
                );
                $tags = $request->get('tags');
                $tags = collect($tags)->map(function ($tag) {
                    return $tag['id'];
                });
                $cupping_event->content->tags()->sync($tags);
                DB::commit();
                return redirect(route('cupping-events-management-page'));
            } else {
                abort(404);
            }
        } catch (\Throwable $ex) {
            DB::rollback();
            logError($ex);
            if ($ex instanceof AuthorizationException) {
                abort(403, getUnAuthorizedAccessMessage());
            } else if ($ex instanceof NotFound) {
                abort(404);
            }
            return abort(503);
        }
    }

    protected function manage()
    {
        try {
            $paging_size = getDefaultPagingSize();
            $data['paging_size'] = $paging_size;
            return Inertia::render('CMS/CuppingEvents/CuppingEventsManagement', $data);
        } catch (\Throwable $ex) {
            logError($ex);
            if ($ex instanceof AuthorizationException) {
                abort(403, getUnAuthorizedAccessMessage());
            } else if ($ex instanceof NotFound) {
                abort(404);
            }
            return abort(503);
        }
    }

    protected function fetch(Request $request)
    {
        try{
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
                        ->whereHasMorph('contentable', [CuppingEvent::class])
                        ->withTrashed()
                        ->unPublished()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [CuppingEvent::class])
                        ->sortBy($sortingColumn, $sortingDirection, CuppingEvent::class)
                        ->paginate($pageSize);
                    break;
                case 2: //published
                    $result = Content::with(['contentable', 'tags'])
                        ->whereHasMorph('contentable', [CuppingEvent::class])
                        ->withTrashed()
                        ->publishedWithoutArchived()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [CuppingEvent::class])
                        ->sortBy($sortingColumn, $sortingDirection, CuppingEvent::class)
                        ->paginate($pageSize);
                    break;
                case 3: //archived
                    $result = Content::with(['contentable','tags'])
                        ->whereHasMorph('contentable', [CuppingEvent::class])
                        ->withTrashed()
                        ->archived()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [CuppingEvent::class])
                        ->sortBy($sortingColumn, $sortingDirection, CuppingEvent::class)
                        ->paginate($pageSize);
                    break;
                default: //any
                    $result = Content::with(['contentable', 'tags'])
                        ->whereHasMorph('contentable', [CuppingEvent::class])
                        ->withTrashed()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [CuppingEvent::class])
                        ->sortBy($sortingColumn, $sortingDirection, CuppingEvent::class)
                        ->paginate($pageSize);
                    break;
            }
            return new JsonResponse($result);
        }
        catch (\Throwable $ex){
            report($ex);
            return new JsonResponse(getGeneralAdminErrorMessage(), 503);
        }
    }
}
