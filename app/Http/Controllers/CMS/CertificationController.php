<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\CMS\CertificationRequest;
use App\Models\Certification;
use App\Models\Content;
use App\Models\Locale;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CertificationController extends Controller
{
    function __construct()
    {
    }

    /**
     * Display a listing of the resource management such as create, edit, delete, and show.
     *
     * @return \Inertia\Response
     */
    protected function manageCertification()
    {
        try {
            $paging_size = getDefaultPagingSize();
            $data['pagingSize'] = $paging_size;
            return Inertia::render('CMS/Certification/ManageCertification', $data);
        } catch (\Throwable $ex) {
            report($ex);
            return back()->with('errorMessage', getGeneralAdminErrorMessage());
        }
    }

    protected function fetchCertification(Request $request)
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
                        ->whereHasMorph('contentable', [Certification::class])
                        ->withTrashed()
                        ->unPublished()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [Certification::class])
                        ->sortBy($sortingColumn, $sortingDirection, Certification::class)
                        ->paginate($pageSize);
                    break;
                case 2: //published
                    $result = Content::with(['contentable', 'tags'])
                        ->whereHasMorph('contentable', [Certification::class])
                        ->withTrashed()
                        ->publishedWithoutArchived()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [Certification::class])
                        ->sortBy($sortingColumn, $sortingDirection, Certification::class)
                        ->paginate($pageSize);
                    break;
                case 3: //archived
                    $result = Content::with(['contentable', 'tags'])
                        ->whereHasMorph('contentable', [Certification::class])
                        ->withTrashed()
                        ->archived()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [Certification::class])
                        ->sortBy($sortingColumn, $sortingDirection, Certification::class)
                        ->paginate($pageSize);
                    break;
                default: //any
                    $result = Content::with(['contentable', 'tags'])
                        ->whereHasMorph('contentable', [Certification::class])
                        ->withTrashed()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [Certification::class])
                        ->sortBy($sortingColumn, $sortingDirection, Certification::class)
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
            $this->authorize('create', new Certification);
            return Inertia::render('CMS/Certification/CreateCertification');
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
     * Shop a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    protected function createPost(CertificationRequest $request)
    {
        DB::beginTransaction();
        try {
            $locale = Locale::where('short_code', getSessionLanguageShortCode())->first();
            if ($locale != null) {
                $content = array('locale_id' => $locale->id);
                $certification = Arr::except($request->all(), ['tags', 'attachments', 'xcsrf']);
                /*Count the number of files selected to be uploaded*/

                $tags = $request->get('tags');
                $tags = collect($tags)->map(function ($tag) {
                    return $tag['id'];
                });
                $certification = Certification::create($certification);
                $this->authorize('create', $certification);
                $attachment = $request->file('attachment');
                if ($attachment != null) {
                    $certification->addMedia($attachment)->toMediaCollection('certificates');
                }
                $content = $certification->content()->create($content);
                $content->tags()->sync($tags);
                DB::commit();
                return redirect()->route('certification-management-page');
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
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Certification $events
     * @return \Inertia\Response
     */
    protected function editGet($certification_id)
    {
        try {
            $certification = Certification::with(['content', 'content.tags'])->find($certification_id);
            $this->authorize('update', $certification);
            $data['certification'] = $certification;
            return Inertia::render('CMS/Certification/EditCertification', $data);
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
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Certification $certification
     * @return \Illuminate\Http\Response
     */
    protected function editPost(CertificationRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $certification = Certification::with('content', 'media')->find($id);
            $this->authorize('update', $certification);
            if ($certification != null) {
                $certification->update(
                    Arr::except($request->all(), ['tags', 'attachments', 'csrf'])
                );
                $tags = $request->get('tags');
                $tags = collect($tags)->map(function ($tag) {
                    return $tag['id'];
                });
                $certification->content->tags()->sync($tags);

                $attachment = $request->file('attachment');
                if ($attachment != null) {
                    $certification->clearMediaCollection('certificates');
                    $certification->addMedia($attachment)->toMediaCollection('certificates');
                }

                DB::commit();
                return redirect()->route('certification-management-page');
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
     * Fetch and Show latest certification on the home page.
     *
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    protected function getLatestCertification(Request $request)
    {
        try {
            $langId = getSessionLanguageId();
            $latestCertification = Content::with('contentable', 'contentable.media')
                ->whereHas('contentable', function ($query) {
                    $query->where('contentable_type', Certification::class);
                })
                ->ofLanguage($langId)
                ->publishedWithoutArchived()
                ->latest('published_at')
                ->take(10)
                ->get();
            return response($latestCertification);
        } catch (\Throwable $ex) {
            logError($ex);
            return $request->wantsJson() ? new JsonResponse(getGeneralAdminErrorMessage(), 503) : back()->with('errorMessage', getGeneralAdminErrorMessage());
        }
    }

    /**
     * Get specific Certification Details from published certification.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Inertia\Response
     */

    protected function getDetail(Request $request, $contentId)
    {
        try {

            $content = Content::withTrashed()
                ->published()
                ->ofLanguage(getSessionLanguageId())
                ->with('contentable', 'tags', 'contentable.media')
                ->withCount('content_hits')
                ->whereHas('contentable', function ($query) {
                    $query->where('contentable_type', Certification::class);
                })->find($contentId);

            if (!empty($content)) {
                //event(new ContentVisited($content, $request));
                $data['content'] = $content;
                return Inertia::render('Public/Certification/CertificationDetail', $data);
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
        try {
            $content = Content::withTrashed()->with('contentable', 'tags')->whereHas('contentable', function ($query) {
                $query->where('contentable_type', Certification::class);
            })->find($contentId);

            $data['content'] = $content;
            return Inertia::render('Public/Certification/CertificationDetail', $data);

        } catch (\Throwable $ex) {
            logError($ex);
            return back()->with('errorMessage', getGeneralAdminErrorMessage());
        }
    }

}
