<?php

namespace App\Http\Controllers\CMS;

use App\Events\ContentVisited;
use App\Http\Controllers\Controller;
use App\Http\Requests\CMS\PartnerFormRequest;
use App\Http\Requests\CMS\PartnerRequest;
use App\Models\Partner;
use App\Models\Content;
use App\Models\Locale;
use App\Rules\ValidFileType;
use App\Rules\ValidImageType;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PartnerController extends Controller
{
    function __construct()
    {
    }
    /**
     * Display a listing of the resource management such as create, edit, delete, and show.
     *
     * @return \Inertia\Response
     */
    protected function managePartner()
    {
        try {
            $paging_size = getDefaultPagingSize();
            $data['pagingSize'] = $paging_size;
            return Inertia::render('CMS/Partner/ManagePartner', $data);
        } catch (\Throwable $ex) {
            report($ex);
            return back()->with('errorMessage', getGeneralAdminErrorMessage());
        }
    }

    protected function fetchPartner(Request $request)
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
                    $result = Content::with(['contentable', 'tags', 'contentable.media'])
                        ->whereHasMorph('contentable', [Partner::class])
                        ->withTrashed()
                        ->unPublished()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [Partner::class])
                        ->sortBy($sortingColumn, $sortingDirection, Partner::class)
                        ->paginate($pageSize);
                    break;
                case 2: //published
                    $result = Content::with(['contentable', 'tags', 'contentable.media'])
                        ->whereHasMorph('contentable', [Partner::class])
                        ->withTrashed()
                        ->publishedWithoutArchived()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [Partner::class])
                        ->sortBy($sortingColumn, $sortingDirection, Partner::class)
                        ->paginate($pageSize);
                    break;
                case 3: //archived
                    $result = Content::with(['contentable', 'tags', 'contentable.media'])
                        ->whereHasMorph('contentable', [Partner::class])
                        ->withTrashed()
                        ->archived()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [Partner::class])
                        ->sortBy($sortingColumn, $sortingDirection, Partner::class)
                        ->paginate($pageSize);
                    break;
                default: //any
                    $result = Content::with(['contentable', 'tags', 'contentable.media'])
                        ->whereHasMorph('contentable', [Partner::class])
                        ->withTrashed()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [Partner::class])
                        ->sortBy($sortingColumn, $sortingDirection, Partner::class)
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
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    protected function createGet()
    {
        try {
            $this->authorize('create', new Partner);
            return Inertia::render('CMS/Partner/CreatePartner');
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    protected function createPost(PartnerRequest $request)
    {
        DB::beginTransaction();
        try {
            $locale = Locale::where('short_code', getSessionLanguageShortCode())->first();
            if ($locale != null) {
                $content = array('locale_id' => $locale->id);
                $partner = Arr::except($request->all(), ['tags', 'attachments', 'xcsrf']);
                $tags = $request->get('tags');
                $tags = collect($tags)->map(function ($tag) {
                    return $tag['id'];
                });
                $attachments = $request->file('attachments');
                $partner = Partner::create($partner);
                $this->authorize('create', $partner);
                if ($attachments != null) {
                    $partner->addMedia($attachments)->toMediaCollection('file-attachments');
                }
                $content = $partner->content()->create($content);
                $content->tags()->sync($tags);
                DB::commit();
                return redirect()->route('partner-management-page');
            }
        } catch
        (\Throwable $ex) {
            DB::rollback();
            logError($ex);
            if ($ex instanceof AuthorizationException) {
                abort(403, getUnAuthorizedAccessMessage());
            }
            return $request->wantsJson() ? new JsonResponse(getGeneralAdminErrorMessage(), 503) : back()->with('errorMessage', getGeneralAdminErrorMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Partner  $events
     * @return \Inertia\Response
     */
    protected function editGet($partner_id)
    {
        try {
            $partner = Partner::with(['content', 'content.tags'])->find($partner_id);
            $this->authorize('update', $partner);
            $data['partner'] = $partner;
            return Inertia::render('CMS/Partner/EditPartner', $data);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    protected function editPost(PartnerRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $partner = Partner::with('content', 'media')->find($id);
            $this->authorize('update', $partner);
            $attachments = $request->file('attachments');
            if ($partner != null) {
                $partner->update(
                    Arr::except($request->all(), ['tags', 'attachments', 'csrf'])
                );
                $tags = $request->get('tags');
                $tags = collect($tags)->map(function ($tag) {
                    return $tag['id'];
                });
                $partner->content->tags()->sync($tags);

                if ($attachments != null) {
                    $partner->clearMediaCollection('file-attachments');
                    $partner->addMedia($attachments)->toMediaCollection('file-attachments');
                }
                DB::commit();
                return redirect()->route('partner-management-page');
            }
        } catch (\Throwable $ex) {
            DB::rollback();
            logError($ex);
            if ($ex instanceof AuthorizationException) {
                abort(403, getUnAuthorizedAccessMessage());
            }
            return $request->wantsJson() ? new JsonResponse(getGeneralAdminErrorMessage(), 503) : back()->with('errorMessage', getGeneralAdminErrorMessage());
        }
    }

    /**
     * Fetch and Show latest partner on the home page.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    protected function getLatestPartner(Request $request)
    {
        try {
            $langId = getSessionLanguageId();
            $latestPartner = Content::with('contentable','contentable.media')->whereHas('contentable', function ($query) {
                $query->where('contentable_type', Partner::class);
            })
            ->publishedWithoutArchived()
            ->ofLanguage($langId)
            ->orderBy('published_at', 'DESC')
            ->get();
            Log::info($latestPartner);
            return response($latestPartner);

        } catch (\Throwable $ex) {
            logError($ex);
            return $request->wantsJson() ? new JsonResponse(getGeneralAdminErrorMessage(), 503) : back()->with('errorMessage', getGeneralAdminErrorMessage());
        }
    }

    /**
     * Get specific Partner Details from published partner.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response $ response
     */

    protected function getDetail(Request $request, $contentId)
    {
        try {

            $content = Content::withTrashed()
                ->published()
                ->ofLanguage(getSessionLanguageId())
                ->with('contentable', 'tags','contentable.media')
                ->withCount('content_hits')
                ->whereHas('contentable', function ($query) {
                $query->where('contentable_type', Partner::class);
            })->find($contentId);

            if (!empty($content)) {
                event(new ContentVisited($content, $request));
                $data['content'] = $content;
                return $request->wantsJson() ? new JsonResponse($content) : Inertia::render('Public/Partner/PartnerDetail', $data);
            } else {
                return abort(404);
            }

        } catch (\Throwable $ex) {
            logError($ex);
            return $request->wantsJson() ? new JsonResponse(getGeneralAdminErrorMessage(), 503) : back()->with('errorMessage', getGeneralAdminErrorMessage());
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
            $content = Content::withTrashed()->with('contentable', 'tags','contentable.media')->whereHas('contentable', function ($query) {
                $query->where('contentable_type', Partner::class);
            })->find($contentId);

            $data['content'] = $content;
            return Inertia::render('Index', $data);

        } catch (\Throwable $ex) {
            logError($ex);
            return back()->with('errorMessage', getGeneralAdminErrorMessage());
        }
    }
}
