<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\CMS\StoreFormRequest;
use App\Models\Content;
use App\Models\Locale;
use App\Models\Store;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StoresController extends Controller
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
                    $query->where('contentable_type', Store::class);
                })->paginate(getDefaultPagingSize());
            $data['contents'] = $content;
            return Inertia::render('Public/Store/StoresIndex', $data);
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
                    $query->where('contentable_type', Store::class);
                })->find($contentId);

            if (!empty($content)) {
                $data['content'] = $content;
                return Inertia::render('Public/Store/StoreDetail', $data);
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
                    $query->where('contentable_type', Store::class);
                })->find($contentId);

            if (!empty($content)) {
                $data['content'] = $content;
                return Inertia::render('Public/Store/StoreDetail', $data);
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
            $this->authorize('create', new Store());
            return Inertia::render('CMS/Stores/CreateStore');
        } catch (\Throwable $ex) {
            logError($ex);
            if ($ex instanceof NotFoundHttpException) {
                abort(404);
            }
            return Inertia::render('Errors/UnhandledException');
        }
    }

    protected function createPost(StoreFormRequest $request)
    {
        try {
            $this->authorize('create', new Store());
            DB::beginTransaction();
            $locale = Locale::where('short_code', getSessionLanguageShortCode())->first();
            if ($locale != null) {
                $content = array('locale_id' => $locale->id);
                $store = Arr::except($request->all(), ['tags', 'xcsrf']);
                $store = Store::create($store);
                $content = $store->content()->create($content);
                $tags = $request->get('tags');
                $tags = collect($tags)->map(function ($tag) {
                    return $tag['id'];
                });
                $content->tags()->sync($tags);
                DB::commit();
                return redirect(route('stores-management-page'));
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

    protected function editGet($store_id)
    {
        try {
            $store = Store::with(['content', 'content.tags'])->find($store_id);
            if (!is_null($store)) {
                $this->authorize('update', $store);
                $data['store'] = $store;
                return Inertia::render('CMS/Stores/StoreEditor', $data);
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

    protected function editPost(StoreFormRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $store = Store::with('content')->find($id);
            $this->authorize('update', $store);

            if ($store != null) {
                $store->update(
                    Arr::except($request->all(), ['tags', 'csrf'])
                );
                $tags = $request->get('tags');
                $tags = collect($tags)->map(function ($tag) {
                    return $tag['id'];
                });
                $store->content->tags()->sync($tags);
                DB::commit();
                return redirect(route('stores-management-page'));
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
            return Inertia::render('CMS/Stores/StoresManagement', $data);
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
                    $result = Content::with(['contentable', 'contentable.country', 'tags'])
                        ->whereHasMorph('contentable', [Store::class])
                        ->withTrashed()
                        ->unPublished()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [Store::class])
                        ->sortBy($sortingColumn, $sortingDirection, Store::class)
                        ->paginate($pageSize);
                    break;
                case 2: //published
                    $result = Content::with(['contentable', 'contentable.country', 'tags'])
                        ->whereHasMorph('contentable', [Store::class])
                        ->withTrashed()
                        ->publishedWithoutArchived()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [Store::class])
                        ->sortBy($sortingColumn, $sortingDirection, Store::class)
                        ->paginate($pageSize);
                    break;
                case 3: //archived
                    $result = Content::with(['contentable', 'contentable.country', 'tags'])
                        ->whereHasMorph('contentable', [Store::class])
                        ->withTrashed()
                        ->archived()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [Store::class])
                        ->sortBy($sortingColumn, $sortingDirection, Store::class)
                        ->paginate($pageSize);
                    break;
                default: //any
                    $result = Content::with(['contentable', 'contentable.country', 'tags'])
                        ->whereHasMorph('contentable', [Store::class])
                        ->withTrashed()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [Store::class])
                        ->sortBy($sortingColumn, $sortingDirection, Store::class)
                        ->paginate($pageSize);
                    break;
            }
            return new JsonResponse($result);
        } catch (\Throwable $ex) {
            report($ex);
            return new JsonResponse(getGeneralAdminErrorMessage(), 503);
        }
    }

    protected function fetchAllStores(Request $request)
    {
        try {

            $langId = getSessionLanguageId();

            $stores = Content::with(['contentable'])
                ->whereHasMorph('contentable', [Store::class])
                ->withTrashed()
                ->publishedWithoutArchived()
                ->ofLanguage($langId)
                ->latest('published_at')
                ->get();

            return new JsonResponse($stores);

        } catch (\Throwable $ex) {
            report($ex);
            return new JsonResponse(getGeneralAdminErrorMessage(), 503);
        }
    }
}
