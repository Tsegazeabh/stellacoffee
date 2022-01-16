<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\CMS\CustomerTestimonialFormRequest;
use App\Models\Content;
use App\Models\CustomerTestimonial;
use App\Models\Locale;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CustomerTestimonialController extends Controller
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
                ->with('contentable')
                ->withCount('content_hits')
                ->whereHas('contentable', function ($query) {
                    $query->where('contentable_type', CustomerTestimonial::class);
                })->paginate(getDefaultPagingSize());
            $data['result'] = $content;
            return Inertia::render('Public/Testimonials/TestimonialsIndex', $data);
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
                ->with('contentable', 'tags')
                ->withCount('content_hits')
                ->whereHas('contentable', function ($query) {
                    $query->where('contentable_type', CustomerTestimonial::class);
                })->find($contentId);

            if (!empty($content)) {
                $data['content'] = $content;
                return Inertia::render('Public/Testimonials/TestimonialDetail', $data);
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
                ->with('contentable', 'tags')
                ->withCount('content_hits')
                ->whereHas('contentable', function ($query) {
                    $query->where('contentable_type', CustomerTestimonial::class);
                })->find($contentId);

            if (!empty($content)) {
                $data['content'] = $content;
                return Inertia::render('Public/Testimonials/TestimonialDetail', $data);
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
            $this->authorize('create', new CustomerTestimonial());
            return Inertia::render('CMS/Testimonials/CreateTestimonial');
        } catch (\Throwable $ex) {
            logError($ex);
            if ($ex instanceof NotFoundHttpException) {
                abort(404);
            }
            return Inertia::render('Errors/UnhandledException');
        }
    }

    protected function createPost(CustomerTestimonialFormRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->authorize('create', new CustomerTestimonial());
            $locale = Locale::where('short_code', getSessionLanguageShortCode())->first();
            if ($locale != null) {
                $content = array('locale_id' => $locale->id);
                $customer_testimonial = Arr::except($request->all(), ['tags', 'xcsrf']);
                $customer_testimonial = CustomerTestimonial::create($customer_testimonial);
                $content = $customer_testimonial->content()->create($content);
                $tags = $request->get('tags');
                $tags = collect($tags)->map(function ($tag) {
                    return $tag['id'];
                });
                $content->tags()->sync($tags);
                DB::commit();
                return redirect(route('testimonials-management-page'));
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

    protected function editGet($customer_testimonial_id)
    {
        try {
            $customer_testimonial = CustomerTestimonial::with(['content', 'content.tags'])->find($customer_testimonial_id);
            if (!is_null($customer_testimonial)) {
                $this->authorize('update', $customer_testimonial);
                $data['customer_testimonial'] = $customer_testimonial;
                return Inertia::render('CMS/Testimonials/TestimonialEditor', $data);
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

    protected function editPost(CustomerTestimonialFormRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $customer_testimonial = CustomerTestimonial::with('content')->find($id);
            $this->authorize('update', $customer_testimonial);

            if ($customer_testimonial != null) {
                $customer_testimonial->update(
                    Arr::except($request->all(), ['tags', 'csrf'])
                );
                $tags = $request->get('tags');
                $tags = collect($tags)->map(function ($tag) {
                    return $tag['id'];
                });
                $customer_testimonial->content->tags()->sync($tags);
                DB::commit();
                return redirect(route('testimonials-management-page'));
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
            return Inertia::render('CMS/Testimonials/TestimonialsManagement', $data);
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
                    $result = Content::with(['contentable', 'tags'])
                        ->whereHasMorph('contentable', [CustomerTestimonial::class])
                        ->withTrashed()
                        ->unPublished()
                        ->ofLanguage($langId)
                        ->searchTestimonials($searchKeyword, [CustomerTestimonial::class])
                        ->sortBy($sortingColumn, $sortingDirection, CustomerTestimonial::class)
                        ->paginate($pageSize);
                    break;
                case 2: //published
                    $result = Content::with(['contentable', 'tags'])
                        ->whereHasMorph('contentable', [CustomerTestimonial::class])
                        ->withTrashed()
                        ->publishedWithoutArchived()
                        ->ofLanguage($langId)
                        ->searchTestimonials($searchKeyword, [CustomerTestimonial::class])
                        ->sortBy($sortingColumn, $sortingDirection, CustomerTestimonial::class)
                        ->paginate($pageSize);
                    break;
                case 3: //archived
                    $result = Content::with(['contentable', 'tags'])
                        ->whereHasMorph('contentable', [CustomerTestimonial::class])
                        ->withTrashed()
                        ->archived()
                        ->ofLanguage($langId)
                        ->searchTestimonials($searchKeyword, [CustomerTestimonial::class])
                        ->sortBy($sortingColumn, $sortingDirection, CustomerTestimonial::class)
                        ->paginate($pageSize);
                    break;
                default: //any
                    $result = Content::with(['contentable', 'tags'])
                        ->whereHasMorph('contentable', [CustomerTestimonial::class])
                        ->withTrashed()
                        ->ofLanguage($langId)
                        ->searchTestimonials($searchKeyword, [CustomerTestimonial::class])
                        ->sortBy($sortingColumn, $sortingDirection, CustomerTestimonial::class)
                        ->paginate($pageSize);
                    break;
            }
            return new JsonResponse($result);
        } catch (\Throwable $ex) {
            report($ex);
            return new JsonResponse(getGeneralAdminErrorMessage(), 503);
        }
    }

    protected function fetchLatestTestimonials(Request $request)
    {
        try {
            $langId = getSessionLanguageId();
            if ($request->route()->hasParameter('preview')) {
                $result = Content::with(['contentable', 'tags'])
                    ->whereHasMorph('contentable', [CustomerTestimonial::class])
                    ->withTrashed()
                    ->ofLanguage($langId)
                    ->latest('created_at')->take(6)->get();
            } else {
                $result = Content::with(['contentable', 'tags'])
                    ->whereHasMorph('contentable', [CustomerTestimonial::class])
                    ->withTrashed()
                    ->publishedWithoutArchived()
                    ->ofLanguage($langId)
                    ->latest('published_at')->take(6)->get();
            }
            return new JsonResponse($result);
        } catch (\Throwable $ex) {
            report($ex);
            return new JsonResponse(getGeneralAdminErrorMessage(), 503);
        }
    }
}
