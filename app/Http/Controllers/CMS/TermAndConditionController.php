<?php

namespace App\Http\Controllers\CMS;

use App\Events\ContentVisited;
use App\Http\Controllers\Controller;
use App\Http\Requests\CMS\TermAndConditionRequest;
use App\Models\Content;
use App\Models\Locale;
use App\Models\TermAndCondition;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TermAndConditionController extends Controller
{
    function __construct()
    {
    }

    /**
     * @param Request $request
     * @return JsonResponse|\Illuminate\Http\RedirectResponse|\Inertia\Response
     */
    protected function manageTermAndCondition(Request $request)
    {
        try {
            $data['pagingSize'] = getDefaultPagingSize();
            return Inertia::render('CMS/TermAndCondition/ManageTermAndCondition', $data);
        } catch (\Throwable $ex) {
            report($ex);
            return back()->withErrors(['errorMessage' => getGeneralAdminErrorMessage()]);
        }
    }

    protected function fetchTermAndCondition(Request $request)
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
                    $result = Content::with(['contentable'])
                        ->whereHasMorph('contentable', [TermAndCondition::class])
                        ->withTrashed()
                        ->unPublished()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [TermAndCondition::class])
                        ->sortBy($sortingColumn, $sortingDirection, TermAndCondition::class)
                        ->paginate($pageSize);
                    break;
                case 2: //published
                    $result = Content::with(['contentable'])
                        ->whereHasMorph('contentable', [TermAndCondition::class])
                        ->withTrashed()
                        ->publishedWithoutArchived()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [TermAndCondition::class])
                        ->sortBy($sortingColumn, $sortingDirection, TermAndCondition::class)
                        ->paginate($pageSize);
                    break;
                case 3: //archived
                    $result = Content::with(['contentable'])
                        ->whereHasMorph('contentable', [TermAndCondition::class])
                        ->withTrashed()
                        ->archived()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [TermAndCondition::class])
                        ->sortBy($sortingColumn, $sortingDirection, TermAndCondition::class)
                        ->paginate($pageSize);
                    break;
                default: //any
                    $result = Content::with(['contentable'])
                        ->whereHasMorph('contentable', [TermAndCondition::class])
                        ->withTrashed()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [TermAndCondition::class])
                        ->sortBy($sortingColumn, $sortingDirection, TermAndCondition::class)
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
            $this->authorize('create', new TermAndCondition);
            return Inertia::render('CMS/TermAndCondition/CreateTermAndCondition');
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
     * @param TermAndConditionRequest $request
     * @return JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function createPost(TermAndConditionRequest $request)
    {
        DB::beginTransaction();
        try {
            $locale = Locale::where('short_code', getSessionLanguageShortCode())->first();
            if ($locale != null) {
                $contents = array('locale_id' => $locale->id);
                $term_and_condition = Arr::except($request->all(), [ 'xcsrf']);
                $term_and_condition = TermAndCondition::create($term_and_condition);
                $this->authorize('create', $term_and_condition);
                $content = $term_and_condition->content()->create($contents);
                DB::commit();
            }
            return redirect()->route('term-and-condition-management-page');

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
     * @param $term_and_condition_id
     * @return \Inertia\Response
     */
    protected function editGet($term_and_condition_id)
    {
        try {
            $term_and_condition = TermAndCondition::with(['content'])->find($term_and_condition_id);
            $this->authorize('update', $term_and_condition);
            $data['term_and_condition'] = $term_and_condition;
            return Inertia::render('CMS/TermAndCondition/EditTermAndCondition', $data);
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
     * @param $term_and_condition_id
     * @param Request $request
     * @return JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function editPost($term_and_condition_id, TermAndConditionRequest $request)
    {
        DB::beginTransaction();
        try {
            $term_and_condition = TermAndCondition::with('content')->find($term_and_condition_id);
            $this->authorize('update', $term_and_condition);

            if ($term_and_condition != null) {
                $term_and_condition->update(
                    Arr::except($request->all(), ['csrf'])
                );
                DB::commit();
                return redirect()->route('term-and-condition-management-page');
            } else {
                return back()->withErrors(['errorMessage' => 'We can not find privacy policy with the specified id!']);
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
    protected function getLatestTermAndCondition(Request $request)
    {
        try {
            $langId = getSessionLanguageId();
            $latestTermAndCondition = Content::with('contentable')
                ->withCount('content_hits')
                ->whereHas('contentable', function ($query) {
                    $query->where('contentable_type', TermAndCondition::class);
                })
                ->publishedWithoutArchived()
                ->ofLanguage($langId)
                ->orderBy('published_at', 'DESC')
                ->take(4)
                ->get();

            return response($latestTermAndCondition);

        } catch (\Throwable $ex) {
            logError($ex);
            return response(getGeneralAdminErrorMessage(), 503);
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
            $langId = getSessionLanguageId();
            $content = Content::withTrashed()
                ->ofLanguage($langId)
                ->with('contentable')
                ->withCount('content_hits')
                ->whereHas('contentable', function ($query) {
                    $query->where('contentable_type', TermAndCondition::class);
                })->find($contentId);

            $data['content'] = $content;
            return Inertia::render('Public/TermAndCondition/TermAndConditionDetail', $data);

        } catch (\Throwable $ex) {
            logError($ex);
            return back()->withErrors(['errorMessage'=> getGeneralAdminErrorMessage()]);
        }
    }

    /**
     * @param Request $request
     * @param $contentId
     * @return JsonResponse|\Illuminate\Http\RedirectResponse|\Inertia\Response
     */
    protected function getDetail(Request $request)
    {
        try {
            $content = Content::publishedWithOutArchived()
                ->withTrashed()
                ->ofLanguage(getSessionLanguageId())
                ->with('contentable')
                ->withCount('content_hits')
                ->whereHas('contentable', function ($query) {
                    $query->where('contentable_type', TermAndCondition::class);
                })->orderBy('published_at', 'DESC')->first();

            if (!empty($content)) {
                event(new ContentVisited($content, $request));
            }
            $data['content'] = $content;
            return Inertia::render('Public/TermAndCondition/TermAndConditionDetail', $data);
        } catch (\Throwable $ex) {
            logError($ex);
            if ($ex instanceof NotFoundHttpException) {
                abort(404);
            }
            return Inertia::render('Errors/UnhandledException');
        }
    }
}
