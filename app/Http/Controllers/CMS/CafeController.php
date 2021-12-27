<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\CMS\CafeRequest;
use App\Models\Cafe;
use App\Models\Content;
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

class CafeController extends Controller
{

    function __construct()
    {
    }

    public function index()
    {
        try {
            return Inertia::render('Public/Cafe/CafeIndex');
        } catch (\Exception $ex) {
            Log::info($ex);
        }
    }
    /**
     * @param Request $request
     * @return JsonResponse|\Illuminate\Http\RedirectResponse|\Inertia\Response
     */
    protected function manageCafe(Request $request)
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
                $query->where('contentable_type', Cafe::class);
            })->orderBy($sort_by, $sorting_method)->paginate($paging_size);

            $data['searchResult'] = $searchResult;

            return Inertia::render('CMS/Cafe/ManageCafe', $data);

        } catch (\Throwable $ex) {
            report($ex);
            if ($ex instanceof NotFound) {
                abort(404);
            }
            return abort(503);
        }
    }

    protected function fetchCafe(Request $request)
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
                        ->whereHasMorph('contentable', [Cafe::class])
                        ->withTrashed()
                        ->unPublished()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [Cafe::class])
                        ->sortBy($sortingColumn, $sortingDirection, Cafe::class)
                        ->paginate($pageSize);
                    break;
                case 2: //published
                    $result = Content::with(['contentable', 'tags'])
                        ->whereHasMorph('contentable', [Cafe::class])
                        ->withTrashed()
                        ->publishedWithoutArchived()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [Cafe::class])
                        ->sortBy($sortingColumn, $sortingDirection, Cafe::class)
                        ->paginate($pageSize);
                    break;
                case 3: //archived
                    $result = Content::with(['contentable', 'tags'])
                        ->whereHasMorph('contentable', [Cafe::class])
                        ->withTrashed()
                        ->archived()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [Cafe::class])
                        ->sortBy($sortingColumn, $sortingDirection, Cafe::class)
                        ->paginate($pageSize);
                    break;
                default: //any
                    $result = Content::with(['contentable', 'tags'])
                        ->whereHasMorph('contentable', [Cafe::class])
                        ->withTrashed()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [Cafe::class])
                        ->sortBy($sortingColumn, $sortingDirection, Cafe::class)
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
            $this->authorize('create', new Cafe);
            if(getSessionLanguageShortCode() == 'am' || getSessionLanguageShortCode() == 'AM'){
                $service_types = DB::table('service_types')->pluck('name_am', 'id');
            }elseif (getSessionLanguageShortCode() == 'fr' || getSessionLanguageShortCode() == 'FR'){
                $service_types = DB::table('service_types')->pluck('name_fr', 'id');
            }elseif (getSessionLanguageShortCode() == 'it' || getSessionLanguageShortCode() == 'IT'){
                $service_types = DB::table('service_types')->pluck('name_it', 'id');
            }else{
                $service_types = DB::table('service_types')->pluck('name', 'id');
            }
            $data['service_types'] = $service_types;
            return Inertia::render('CMS/Cafe/CreateCafe',$data);
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
     * @param CreateCafe $request
     * @return JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function createPost(CafeRequest $request)
    {
        DB::beginTransaction();
        try {
            $locale = Locale::where('short_code', getSessionLanguageShortCode())->first();
            if ($locale != null) {
                $content = array('locale_id' => $locale->id);
                $cafe = Arr::except($request->all(), ['tags', 'attachments', 'xcsrf']);
                $tags = $request->get('tags');
                $tags = collect($tags)->map(function ($tag) {
                    return $tag['id'];
                });
                $attachments = $request->file('attachments');
                $cafe = Cafe::create($cafe);
                $this->authorize('create', $cafe);
                if ($attachments != null) {
                    $cafe->addMedia($attachments)->toMediaCollection('file-attachments');
                }
                $content = $cafe->content()->create($content);
                $content->tags()->sync($tags);
                DB::commit();
                return redirect()->route('cafe-management-page');
            }
        } catch
        (\Throwable $ex) {
            DB::rollback();
            logError($ex);
            if ($ex instanceof AuthorizationException) {
                abort(403, getUnAuthorizedAccessMessage());
            }
            return back(503)->withErrors(['errorMessage' => getGeneralAdminErrorMessage()]);
        }
    }


    /**
     * @param $cafe_id
     * @return \Inertia\Response
     */
    protected function editGet($cafe_id)
    {
        try {
            $cafe = Cafe::with(['content', 'content.tags'])->find($cafe_id);
            $this->authorize('update', $cafe);
            $data['cafe'] = $cafe;
            if(getSessionLanguageShortCode() == 'am' || getSessionLanguageShortCode() == 'AM'){
                $service_types = DB::table('service_types')->pluck('name_am', 'id');
            }elseif (getSessionLanguageShortCode() == 'fr' || getSessionLanguageShortCode() == 'FR'){
                $service_types = DB::table('service_types')->pluck('name_fr', 'id');
            }elseif (getSessionLanguageShortCode() == 'it' || getSessionLanguageShortCode() == 'IT'){
                $service_types = DB::table('service_types')->pluck('name_it', 'id');
            }else{
                $service_types = DB::table('service_types')->pluck('name', 'id');
            }
            $data['service_types'] = $service_types;
            return Inertia::render('CMS/Cafe/EditCafe', $data);
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
     * @param $cafe_id
     * @param Request $request
     * @return JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function editPost($cafe_id, CafeRequest $request)
    {
        DB::beginTransaction();
        try {
            $cafe = Cafe::with('content', 'media')->find($cafe_id);
            $this->authorize('update', $cafe);
            $attachments = $request->file('attachments');
            if ($cafe != null) {
                $cafe->update(
                    Arr::except($request->all(), ['tags', 'attachments', 'csrf'])
                );
                $tags = $request->get('tags');
                $tags = collect($tags)->map(function ($tag) {
                    return $tag['id'];
                });
                $cafe->content->tags()->sync($tags);

                if ($attachments != null) {
                    $cafe->clearMediaCollection('file-attachments');
                    $cafe->addMedia($attachments)->toMediaCollection('file-attachments');
                }
                DB::commit();
                return redirect()->route('cafe-management-page');
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
    protected function getLatestCafe(Request $request)
    {
        try {
            $langId = getSessionLanguageId();
            $pageSize = $request->get('pageSize', getDefaultPagingSize());
            $latestCafe = Content::with('contentable')->whereHas('contentable', function ($query) {
                $query->where('contentable_type', Cafe::class);
            })
                ->ofLanguage($langId)
                ->publishedWithoutArchived()
                ->orderBy('published_at', 'DESC')
                ->paginate($pageSize);
            return response($latestCafe);
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
                $query->where('contentable_type', Cafe::class);
            })->find($contentId);

            $data['content'] = $content;
            return Inertia::render('Public/Cafe/CafeDetail', $data);

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
                    $query->where('contentable_type', Cafe::class);
                })->find($contentId);
            if (!empty($content)) {
                $data['content'] = $content;
                return Inertia::render('Public/Cafe/CafeDetail', $data);
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
