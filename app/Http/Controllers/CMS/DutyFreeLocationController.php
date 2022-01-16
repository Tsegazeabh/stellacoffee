<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\CMS\DutyFreeLocationFormRequest;
use App\Models\Content;
use App\Models\DutyFreeLocation;
use App\Models\Locale;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DutyFreeLocationController extends Controller
{
    public function __construct()
    {
    }

    protected function index(Request $request)
    {
        try {
            $content = Content::withTrashed()
                ->publishedWithoutArchived()
                ->ofLanguage(getSessionLanguageId())
                ->with('contentable', 'contentable.country')
                ->withCount('content_hits')
                ->whereHas('contentable', function ($query) {
                    $query->where('contentable_type', DutyFreeLocation::class);
                })->paginate(getDefaultPagingSize());
            $data['result'] = $content;
            return Inertia::render('Public/DutyFreeLocations/DutyFreeLocationIndex', $data);
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
                ->with('contentable', 'tags', 'contentable.country')
                ->withCount('content_hits')
                ->whereHas('contentable', function ($query) {
                    $query->where('contentable_type', DutyFreeLocation::class);
                })->find($contentId);

            if (!empty($content)) {
                $data['content'] = $content;
                return Inertia::render('Public/DutyFreeLocations/DutyFreeLocationDetail', $data);
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
                ->with('contentable', 'tags', 'contentable.country')
                ->withCount('content_hits')
                ->whereHas('contentable', function ($query) {
                    $query->where('contentable_type', DutyFreeLocation::class);
                })->find($contentId);

            if (!empty($content)) {
                $data['content'] = $content;
                return Inertia::render('Public/DutyFreeLocations/DutyFreeLocationDetail', $data);
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
            $this->authorize('create', new DutyFreeLocation());
            return Inertia::render('CMS/DutyFreeLocations/CreateDutyFreeLocation');
        } catch (\Throwable $ex) {
            logError($ex);
            if ($ex instanceof NotFoundHttpException) {
                abort(404);
            }
            return Inertia::render('Errors/UnhandledException');
        }
    }

    protected function createPost(DutyFreeLocationFormRequest $request)
    {
        try {
            $this->authorize('create', new DutyFreeLocation());
            DB::beginTransaction();
            $locale = Locale::where('short_code', getSessionLanguageShortCode())->first();
            if ($locale != null) {
                $content = array('locale_id' => $locale->id);
                $duty_free_location = Arr::except($request->all(), ['tags', 'xcsrf']);
                $duty_free_location = DutyFreeLocation::create($duty_free_location);
                $content = $duty_free_location->content()->create($content);
                $tags = $request->get('tags');
                $tags = collect($tags)->map(function ($tag) {
                    return $tag['id'];
                });
                $content->tags()->sync($tags);
                DB::commit();
                return redirect(route('duty-free-locations-management-page'));
            } else {
                return back()->withErrors(['language' => 'Locale not found']);
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

    protected function editGet($duty_free_location_id)
    {
        try {
            $duty_free_location = DutyFreeLocation::with(['content', 'content.tags'])->find($duty_free_location_id);
            if (!is_null($duty_free_location)) {
                $this->authorize('update', $duty_free_location);
                $data['duty_free_location'] = $duty_free_location;
                return Inertia::render('CMS/DutyFreeLocations/DutyFreeLocationEditor', $data);
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

    protected function editPost(DutyFreeLocationFormRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $duty_free_location = DutyFreeLocation::with('content')->find($id);
            $this->authorize('update', $duty_free_location);

            if ($duty_free_location != null) {
                $duty_free_location->update(
                    Arr::except($request->all(), ['tags', 'csrf'])
                );
                $tags = $request->get('tags');
                $tags = collect($tags)->map(function ($tag) {
                    return $tag['id'];
                });
                $duty_free_location->content->tags()->sync($tags);
                DB::commit();
                return redirect(route('duty-free-locations-management-page'));
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
            return Inertia::render('CMS/DutyFreeLocations/DutyFreeLocationManagement', $data);
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
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
                    $result = Content::with(['contentable', 'contentable.country', 'tags'])
                        ->whereHasMorph('contentable', [DutyFreeLocation::class])
                        ->withTrashed()
                        ->unPublished()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [DutyFreeLocation::class])
                        ->sortBy($sortingColumn, $sortingDirection, DutyFreeLocation::class)
                        ->paginate($pageSize);
                    break;
                case 2: //published
                    $result = Content::with(['contentable', 'contentable.country', 'tags'])
                        ->whereHasMorph('contentable', [DutyFreeLocation::class])
                        ->withTrashed()
                        ->publishedWithoutArchived()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [DutyFreeLocation::class])
                        ->sortBy($sortingColumn, $sortingDirection, DutyFreeLocation::class)
                        ->paginate($pageSize);
                    break;
                case 3: //archived
                    $result = Content::with(['contentable', 'contentable.country', 'tags'])
                        ->whereHasMorph('contentable', [DutyFreeLocation::class])
                        ->withTrashed()
                        ->archived()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [DutyFreeLocation::class])
                        ->sortBy($sortingColumn, $sortingDirection, DutyFreeLocation::class)
                        ->paginate($pageSize);
                    break;
                default: //any
                    $result = Content::with(['contentable', 'contentable.country', 'tags'])
                        ->whereHasMorph('contentable', [DutyFreeLocation::class])
                        ->withTrashed()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [DutyFreeLocation::class])
                        ->sortBy($sortingColumn, $sortingDirection, DutyFreeLocation::class)
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
