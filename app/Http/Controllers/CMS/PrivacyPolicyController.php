<?php

namespace App\Http\Controllers\CMS;

use App\Events\ContentVisited;
use App\Http\Controllers\Controller;
use App\Http\Requests\CMS\PrivacyPolicyRequest;
use App\Models\Content;
use App\Models\Locale;
use App\Models\PrivacyPolicy;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PrivacyPolicyController extends Controller
{
    function __construct()
    {
    }

    /**
     * @param Request $request
     * @return JsonResponse|\Illuminate\Http\RedirectResponse|\Inertia\Response
     */
    protected function managePrivacyPolicy(Request $request)
    {
        try {
            $data['pagingSize'] = getDefaultPagingSize();
            return Inertia::render('CMS/PrivacyPolicy/ManagePrivacyPolicy', $data);
        } catch (\Throwable $ex) {
            report($ex);
            return back()->withErrors(['errorMessage' => getGeneralAdminErrorMessage()]);
        }
    }

    protected function fetchPrivacyPolicy(Request $request)
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
                        ->whereHasMorph('contentable', [PrivacyPolicy::class])
                        ->withTrashed()
                        ->unPublished()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [PrivacyPolicy::class])
                        ->sortBy($sortingColumn, $sortingDirection, PrivacyPolicy::class)
                        ->paginate($pageSize);
                    break;
                case 2: //published
                    $result = Content::with(['contentable'])
                        ->whereHasMorph('contentable', [PrivacyPolicy::class])
                        ->withTrashed()
                        ->publishedWithoutArchived()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [PrivacyPolicy::class])
                        ->sortBy($sortingColumn, $sortingDirection, PrivacyPolicy::class)
                        ->paginate($pageSize);
                    break;
                case 3: //archived
                    $result = Content::with(['contentable'])
                        ->whereHasMorph('contentable', [PrivacyPolicy::class])
                        ->withTrashed()
                        ->archived()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [PrivacyPolicy::class])
                        ->sortBy($sortingColumn, $sortingDirection, PrivacyPolicy::class)
                        ->paginate($pageSize);
                    break;
                default: //any
                    $result = Content::with(['contentable'])
                        ->whereHasMorph('contentable', [PrivacyPolicy::class])
                        ->withTrashed()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [PrivacyPolicy::class])
                        ->sortBy($sortingColumn, $sortingDirection, PrivacyPolicy::class)
                        ->paginate($pageSize);
                    break;
            }
            return new JsonResponse($result);
        } catch (\Throwable $ex) {
            logError($ex);
            return new JsonResponse(getGeneralAdminErrorMessage(), 503);
        }
    }
    /**
     * @return \Inertia\Response
     */
    protected function createGet()
    {
        try {
            $this->authorize('create', new PrivacyPolicy);
            return Inertia::render('CMS/PrivacyPolicy/CreatePrivacyPolicy');
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
     * @param PrivacyPolicyRequest $request
     * @return JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function createPost(PrivacyPolicyRequest $request)
    {
        DB::beginTransaction();
        try {
            $locale = Locale::where('short_code', getSessionLanguageShortCode())->first();
            if ($locale != null) {
                $content = array('locale_id' => $locale->id);
                $privacy_policy = Arr::except($request->all(), ['xcsrf']);
                $privacy_policy = PrivacyPolicy::create($privacy_policy);
                $this->authorize('create', $privacy_policy);
                $content = $privacy_policy->content()->create($content);
                DB::commit();
            }
            return redirect()->route('privacy-policy-management-page');

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
     * @param $privacy_policy_id
     * @return \Inertia\Response
     */
    protected function editGet($privacy_policy_id)
    {
        try {
            $privacy_policy = PrivacyPolicy::with(['content'])->find($privacy_policy_id);
            $this->authorize('update', $privacy_policy);
            $data['privacy_policy'] = $privacy_policy;
            return Inertia::render('CMS/PrivacyPolicy/EditPrivacyPolicy', $data);
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
     * @param $privacy_policy_id
     * @param Request $request
     * @return JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function editPost($privacy_policy_id, PrivacyPolicyRequest $request)
    {
        DB::beginTransaction();
        try {
            $privacy_policy = PrivacyPolicy::with('content')->find($privacy_policy_id);
            $this->authorize('update', $privacy_policy);

            if ($privacy_policy != null) {
                $privacy_policy->update(
                    Arr::except($request->all(), ['csrf'])
                );
                DB::commit();
                return redirect()->route('privacy-policy-management-page');
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
    protected function getLatestPrivacyPolicy(Request $request)
    {
        try {
            $langId = getSessionLanguageId();
            $latestPrivacyPolicy = Content::with('contentable')
                ->withCount('content_hits')
                ->whereHas('contentable', function ($query) {
                    $query->where('contentable_type', PrivacyPolicy::class);
                })
                ->publishedWithoutArchived()
                ->ofLanguage($langId)
                ->orderBy('published_at', 'DESC')
                ->take(1)
                ->get();
            return response($latestPrivacyPolicy);

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
                    $query->where('contentable_type', PrivacyPolicy::class);
                })->find($contentId);

            $data['content'] = $content;
            return Inertia::render('Public/PrivacyPolicy/PrivacyPolicyDetail', $data);

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
                    $query->where('contentable_type', PrivacyPolicy::class);
                })->orderBy('published_at', 'DESC')->first();

            if (!empty($content)) {
                event(new ContentVisited($content, $request));
            }
            $data['content'] = $content;
            return Inertia::render('Public/PrivacyPolicy/PrivacyPolicyDetail', $data);
        } catch (\Throwable $ex) {
            logError($ex);
            if ($ex instanceof NotFoundHttpException) {
                abort(404);
            }
            return Inertia::render('Errors/UnhandledException');
        }
    }
}
