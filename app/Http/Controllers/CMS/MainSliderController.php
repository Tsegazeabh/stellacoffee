<?php

namespace App\Http\Controllers\CMS;

use App\Events\ContentVisited;
use App\Http\Controllers\Controller;
use App\Http\Requests\CMS\MainSliderRequest;
use App\Models\Content;
use App\Models\Locale;
use App\Models\MainSlider;
use App\Rules\ValidImageType;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MainSliderController extends Controller
{
    function __construct()
    {
    }

    /**
     * Display a listing of the resource management such as create, edit, delete, and show.
     *
     * @return \Inertia\Response
     */
    protected function manageMainSlider(Request $request)
    {
        try {
            $paging_size = getDefaultPagingSize();
            $data['pagingSize'] = $paging_size;
            return Inertia::render('CMS/MainSlider/ManageMainSlider', $data);
        } catch (\Throwable $ex) {
            report($ex);
            return back()->with('errorMessage', getGeneralAdminErrorMessage());
        }
    }

    protected function fetchMainSlider(Request $request)
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
                        ->whereHasMorph('contentable', [MainSlider::class])
                        ->withTrashed()
                        ->unPublished()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [MainSlider::class])
                        ->sortBy($sortingColumn, $sortingDirection, MainSlider::class)
                        ->paginate($pageSize);
                    break;
                case 2: //published
                    $result = Content::with(['contentable', 'tags', 'contentable.media'])
                        ->whereHasMorph('contentable', [MainSlider::class])
                        ->withTrashed()
                        ->publishedWithoutArchived()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [MainSlider::class])
                        ->sortBy($sortingColumn, $sortingDirection, MainSlider::class)
                        ->paginate($pageSize);
                    break;
                case 3: //archived
                    $result = Content::with(['contentable', 'tags', 'contentable.media'])
                        ->whereHasMorph('contentable', [MainSlider::class])
                        ->withTrashed()
                        ->archived()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [MainSlider::class])
                        ->sortBy($sortingColumn, $sortingDirection, MainSlider::class)
                        ->paginate($pageSize);
                    break;
                default: //any
                    $result = Content::with(['contentable', 'tags', 'contentable.media'])
                        ->whereHasMorph('contentable', [MainSlider::class])
                        ->withTrashed()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [MainSlider::class])
                        ->sortBy($sortingColumn, $sortingDirection, MainSlider::class)
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
            $this->authorize('create', new MainSlider);
            return Inertia::render('CMS/MainSlider/CreateMainSlider');
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
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    protected function createPost(MainSliderRequest $request)
    {
        DB::beginTransaction();
        try {
            $locale = Locale::where('short_code', getSessionLanguageShortCode())->first();
            if ($locale != null) {
                $content = array('locale_id' => $locale->id);
                $main_slider = Arr::except($request->all(), ['tags', 'attachments', 'xcsrf']);
                $tags = $request->get('tags');
                $tags = collect($tags)->map(function ($tag) {
                    return $tag['id'];
                });
                $attachments = $request->file('attachments');
                $main_slider = MainSlider::create($main_slider);
                $this->authorize('create', $main_slider);
                if ($attachments != null) {
                    $main_slider->addMedia($attachments)->toMediaCollection('file-attachments');
                }
                $content = $main_slider->content()->create($content);
                $content->tags()->sync($tags);
                DB::commit();
                return redirect()->route('main-slider-management-page');
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
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\MainSlider $events
     * @return \Inertia\Response
     */
    protected function editGet($main_slider_id)
    {
        try {
            $main_slider = MainSlider::with(['content', 'content.tags'])->find($main_slider_id);
            $this->authorize('update', $main_slider);
            $data['main_slider'] = $main_slider;
            return Inertia::render('CMS/MainSlider/EditMainSlider', $data);
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
     * @param \App\Models\MainSlider $main_slider
     * @return \Illuminate\Http\Response
     */
    protected function editPost(MainSliderRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $main_slider = MainSlider::with('content', 'media')->find($id);
            $this->authorize('update', $main_slider);
            $attachments = $request->file('attachments');
            if ($main_slider != null) {
                $main_slider->update(
                    Arr::except($request->all(), ['tags', 'attachments', 'csrf'])
                );
                $tags = $request->get('tags');
                $tags = collect($tags)->map(function ($tag) {
                    return $tag['id'];
                });
                $main_slider->content->tags()->sync($tags);

                if ($attachments != null) {
                    $main_slider->clearMediaCollection('file-attachments');
                    $main_slider->addMedia($attachments)->toMediaCollection('file-attachments');
                }
                DB::commit();
                return redirect()->route('main-slider-management-page');
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
     * Fetch and Show latest main_slider on the home page.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    protected function getLatestMainSlider(Request $request)
    {
        try {
            $latestMainSlider = Content::with('contentable', 'contentable.media')->whereHas('contentable', function ($query) {
                $query->where('contentable_type', MainSlider::class);
            })->publishedWithoutArchived()->orderBy('published_at', 'DESC')->get();

            return response($latestMainSlider);

        } catch (\Throwable $ex) {
            logError($ex);
            return new JsonResponse(getGeneralAdminErrorMessage(), 503);
        }
    }

    /**
     * Get specific MainSlider Details from published main_slider.
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
                    $query->where('contentable_type', MainSlider::class);
                })->find($contentId);

            if (!empty($content)) {
                event(new ContentVisited($content, $request));
                $data['content'] = $content;
                return Inertia::render('Public/MainSlider/MainSliderDetail', $data);
            } else {
                return abort(404);
            }

        } catch (\Throwable $ex) {
            logError($ex);

            if ($ex instanceof NotFound) {
                abort(404);
            }
            abort(503);
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
            $content = Content::withTrashed()->with('contentable', 'tags', 'contentable.media')->whereHas('contentable', function ($query) {
                $query->where('contentable_type', MainSlider::class);
            })->find($contentId);

            $data['content'] = $content;
            return Inertia::render('Index', $data);

        } catch (\Throwable $ex) {
            logError($ex);
            return back()->with('errorMessage', getGeneralAdminErrorMessage());
        }
    }
}
