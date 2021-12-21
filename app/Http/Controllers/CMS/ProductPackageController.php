<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\CMS\ProductPackageRequest;
use App\Models\Content;
use App\Models\Locale;
use App\Models\ProductPackage;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductPackageController extends Controller
{

    function __construct()
    {
    }

    public function index()
    {
        try {
            return Inertia::render('Public/ProductPackage/ProductPackageIndex');
        } catch (\Exception $ex) {
            Log::info($ex);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse|\Illuminate\Http\RedirectResponse|\Inertia\Response
     */
    protected function manageProductPackage(Request $request)
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
                $query->where('contentable_type', ProductPackage::class);
            })->orderBy($sort_by, $sorting_method)->paginate($paging_size);

            $data['searchResult'] = $searchResult;

            return Inertia::render('CMS/ProductPackage/ManageProductPackage', $data);

        } catch (\Throwable $ex) {
            report($ex);
            if ($ex instanceof NotFound) {
                abort(404);
            }
            return abort(503);
        }
    }

    protected function fetchProductPackage(Request $request)
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
                        ->whereHasMorph('contentable', [ProductPackage::class])
                        ->withTrashed()
                        ->unPublished()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [ProductPackage::class])
                        ->sortBy($sortingColumn, $sortingDirection, ProductPackage::class)
                        ->paginate($pageSize);
                    break;
                case 2: //published
                    $result = Content::with(['contentable', 'tags'])
                        ->whereHasMorph('contentable', [ProductPackage::class])
                        ->withTrashed()
                        ->publishedWithoutArchived()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [ProductPackage::class])
                        ->sortBy($sortingColumn, $sortingDirection, ProductPackage::class)
                        ->paginate($pageSize);
                    break;
                case 3: //archived
                    $result = Content::with(['contentable', 'tags'])
                        ->whereHasMorph('contentable', [ProductPackage::class])
                        ->withTrashed()
                        ->archived()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [ProductPackage::class])
                        ->sortBy($sortingColumn, $sortingDirection, ProductPackage::class)
                        ->paginate($pageSize);
                    break;
                default: //any
                    $result = Content::with(['contentable', 'tags'])
                        ->whereHasMorph('contentable', [ProductPackage::class])
                        ->withTrashed()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [ProductPackage::class])
                        ->sortBy($sortingColumn, $sortingDirection, ProductPackage::class)
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
            $this->authorize('create', new ProductPackage);
            return Inertia::render('CMS/ProductPackage/CreateProductPackage');
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
     * @param CreateProductPackage $request
     * @return JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function createPost(ProductPackageRequest $request)
    {
        DB::beginTransaction();
        try {
            $locale = Locale::where('short_code', getSessionLanguageShortCode())->first();
            if ($locale != null) {
                $content = array('locale_id' => $locale->id);
                $product_package = Arr::except($request->all(), ['tags', 'xcsrf']);
                $product_package = ProductPackage::create($product_package);
                $this->authorize('create', $product_package);
                $content = $product_package->content()->create($content);
                $tags = $request->get('tags');
                $tags = collect($tags)->map(function ($tag) {
                    return $tag['id'];
                });
                $content->tags()->sync($tags);
                DB::commit();
            }
            return redirect()->route('product-package-management-page');

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


    /**
     * @param $product_package_id
     * @return \Inertia\Response
     */
    protected function editGet($product_package_id)
    {
        try {
            $product_package = ProductPackage::with(['content', 'content.tags'])->find($product_package_id);
            $this->authorize('update', $product_package);
            $data['product_package'] = $product_package;
            return Inertia::render('CMS/ProductPackage/EditProductPackage', $data);
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
     * @param $product_package_id
     * @param Request $request
     * @return JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function editPost($product_package_id, ProductPackageRequest $request)
    {
        DB::beginTransaction();
        try {
            $product_package = ProductPackage::with('content')->find($product_package_id);
            $this->authorize('update', $product_package);
            if ($product_package != null) {
                $product_package->update(
                    Arr::except($request->all(), ['tags', 'csrf'])
                );
                $tags = $request->get('tags');
                $tags = collect($tags)->map(function ($tag) {
                    return $tag['id'];
                });
                $product_package->content->tags()->sync($tags);
                DB::commit();
                return redirect()->route('product-package-management-page');
            } else {
                return bacK()->withErrors(['errorMessage' => 'We can not find product package with the specified id!']);
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

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    protected function getLatestProductPackage(Request $request)
    {
        try {
            $langId = getSessionLanguageId();
            $latestProductPackage = Content::with('contentable')
                ->whereHas('contentable', function ($query) {
                    $query->where('contentable_type', ProductPackage::class);
                })
                ->ofLanguage($langId)
                ->publishedWithoutArchived()
                ->latest('published_at')
                ->get();
            return response($latestProductPackage);

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
        try {
            $content = Content::withTrashed()->with('contentable', 'tags')->whereHas('contentable', function ($query) {
                $query->where('contentable_type', ProductPackage::class);
            })->find($contentId);

            $data['content'] = $content;
            return Inertia::render('Public/ProductPackage/ProductPackageDetail', $data);

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
        try {
            $content = Content::withTrashed()
                ->published()
                ->ofLanguage(getSessionLanguageId())
                ->with('contentable', 'tags')
                ->withCount('content_hits')
                ->whereHas('contentable', function ($query) {
                    $query->where('contentable_type', ProductPackage::class);
                })->find($contentId);
            if (!empty($content)) {
                $data['content'] = $content;
                return Inertia::render('Public/ProductPackage/ProductPackageDetail', $data);
            } else {
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
