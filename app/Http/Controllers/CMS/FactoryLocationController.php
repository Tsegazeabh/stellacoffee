<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\CMS\FactoryLocationFormRequest;
use App\Models\Content;
use App\Models\FactoryLocation;
use App\Models\Locale;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FactoryLocationController extends Controller
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
                ->with('contentable', 'contentable.country', 'contentable.city')
                ->withCount('content_hits')
                ->whereHas('contentable', function ($query) {
                    $query->where('contentable_type', FactoryLocation::class);
                })->paginate(getDefaultPagingSize());
            $data['contents'] = $content;
            return Inertia::render('Public/FactoryLocations/FactoryLocationsIndex', $data);
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
                ->with('contentable', 'tags', 'contentable.country', 'contentable.city')
                ->withCount('content_hits')
                ->whereHas('contentable', function ($query) {
                    $query->where('contentable_type', FactoryLocation::class);
                })->find($contentId);

            if (!empty($content)) {
                $data['content'] = $content;
                return Inertia::render('Public/FactoryLocations/FactoryLocationDetail', $data);
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
                ->with('contentable', 'tags', 'contentable.country', 'contentable.city')
                ->withCount('content_hits')
                ->whereHas('contentable', function ($query) {
                    $query->where('contentable_type', FactoryLocation::class);
                })->find($contentId);

            if (!empty($content)) {
                $data['content'] = $content;
                return Inertia::render('Public/FactoryLocations/FactoryLocationDetail', $data);
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
            $this->authorize('create', new FactoryLocation());
            return Inertia::render('CMS/FactoryLocations/CreateFactoryLocation');
        } catch (\Throwable $ex) {
            logError($ex);
            if ($ex instanceof NotFoundHttpException) {
                abort(404);
            }
            return Inertia::render('Errors/UnhandledException');
        }
    }

    protected function createPost(FactoryLocationFormRequest $request)
    {
        try {
            $this->authorize('create', new FactoryLocation());
            DB::beginTransaction();
            $locale = Locale::where('short_code', getSessionLanguageShortCode())->first();
            if ($locale != null) {
                $content = array('locale_id' => $locale->id);
                $duty_free_location = Arr::except($request->all(), ['tags', 'xcsrf']);
                $duty_free_location = FactoryLocation::create($duty_free_location);
                $content = $duty_free_location->content()->create($content);
                $tags = $request->get('tags');
                $tags = collect($tags)->map(function ($tag) {
                    return $tag['id'];
                });
                $content->tags()->sync($tags);
                DB::commit();
                return redirect(route('factory-locations-management-page'));
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

    protected function editGet($factory_location_id)
    {
        try {
            $factory_location = FactoryLocation::with(['content', 'city', 'content.tags'])->find($factory_location_id);
            if (!is_null($factory_location)) {
                $this->authorize('update', $factory_location);
                $data['factory_location'] = $factory_location;
                return Inertia::render('CMS/FactoryLocations/FactoryLocationEditor', $data);
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

    protected function editPost(FactoryLocationFormRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $factory_location = FactoryLocation::with('content')->find($id);
            $this->authorize('update', $factory_location);

            if ($factory_location != null) {
                $factory_location->update(
                    Arr::except($request->all(), ['tags', 'csrf'])
                );
                $tags = $request->get('tags');
                $tags = collect($tags)->map(function ($tag) {
                    return $tag['id'];
                });
                $factory_location->content->tags()->sync($tags);
                DB::commit();
                return redirect(route('factory-locations-management-page'));
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
            return Inertia::render('CMS/FactoryLocations/FactoryLocationManagement', $data);
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
                    $result = Content::with(['contentable', 'contentable.country', 'contentable.city', 'tags'])
                        ->whereHasMorph('contentable', [FactoryLocation::class])
                        ->withTrashed()
                        ->unPublished()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [FactoryLocation::class])
                        ->sortBy($sortingColumn, $sortingDirection, FactoryLocation::class)
                        ->paginate($pageSize);
                    break;
                case 2: //published
                    $result = Content::with(['contentable', 'contentable.country', 'contentable.city', 'tags'])
                        ->whereHasMorph('contentable', [FactoryLocation::class])
                        ->withTrashed()
                        ->publishedWithoutArchived()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [FactoryLocation::class])
                        ->sortBy($sortingColumn, $sortingDirection, FactoryLocation::class)
                        ->paginate($pageSize);
                    break;
                case 3: //archived
                    $result = Content::with(['contentable', 'contentable.country', 'contentable.city', 'tags'])
                        ->whereHasMorph('contentable', [FactoryLocation::class])
                        ->withTrashed()
                        ->archived()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [FactoryLocation::class])
                        ->sortBy($sortingColumn, $sortingDirection, FactoryLocation::class)
                        ->paginate($pageSize);
                    break;
                default: //any
                    $result = Content::with(['contentable', 'contentable.country', 'contentable.city', 'tags'])
                        ->whereHasMorph('contentable', [FactoryLocation::class])
                        ->withTrashed()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [FactoryLocation::class])
                        ->sortBy($sortingColumn, $sortingDirection, FactoryLocation::class)
                        ->paginate($pageSize);
                    break;
            }

            Log::info($result);
            return new JsonResponse($result);
        } catch (\Throwable $ex) {
            report($ex);
            return new JsonResponse(getGeneralAdminErrorMessage(), 503);
        }
    }
}
