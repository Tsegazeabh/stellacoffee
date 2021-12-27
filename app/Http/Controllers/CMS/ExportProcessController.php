<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\CMS\ExportProcessFormRequest;
use App\Models\Content;
use App\Models\ExportProcess;
use App\Models\Locale;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExportProcessController extends Controller
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
                    $query->where('contentable_type', ExportProcess::class);
                })->paginate(getDefaultPagingSize());
            $data['result'] = $content;
            return Inertia::render('Public/ExportProcess/ExportProcessIndex', $data);
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
                    $query->where('contentable_type', ExportProcess::class);
                })->find($contentId);

            if (!empty($content)) {
                $data['content'] = $content;
                return Inertia::render('Public/ExportProcess/ExportProcessDetail', $data);
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
                    $query->where('contentable_type', ExportProcess::class);
                })->find($contentId);

            if (!empty($content)) {
                $data['content'] = $content;
                return Inertia::render('Public/ExportProcess/ExportProcessDetail', $data);
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
            $this->authorize('create', new ExportProcess());
            return Inertia::render('CMS/ExportProcess/CreateExportProcess');
        } catch (\Throwable $ex) {
            logError($ex);
            if ($ex instanceof NotFoundHttpException) {
                abort(404);
            }
            return Inertia::render('Errors/UnhandledException');
        }
    }

    protected function createPost(ExportProcessFormRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->authorize('create', new ExportProcess());
            $locale = Locale::where('short_code', getSessionLanguageShortCode())->first();
            if ($locale != null) {
                $content = array('locale_id' => $locale->id);
                $export_process = Arr::except($request->all(), ['tags', 'xcsrf']);
                $export_process = ExportProcess::create($export_process);
                $content = $export_process->content()->create($content);
                $tags = $request->get('tags');
                $tags = collect($tags)->map(function ($tag) {
                    return $tag['id'];
                });
                $content->tags()->sync($tags);
                DB::commit();
                return redirect(route('export-process-management-page'));
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

    protected function editGet($export_process_id)
    {
        try {
            $export_process = ExportProcess::with(['content', 'content.tags'])->find($export_process_id);
            if (!is_null($export_process)) {
                $this->authorize('update', $export_process);
                $data['export_process'] = $export_process;
                return Inertia::render('CMS/ExportProcess/ExportProcessEditor', $data);
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

    protected function editPost(ExportProcessFormRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $export_process = ExportProcess::with('content')->find($id);
            $this->authorize('update', $export_process);

            if ($export_process != null) {
                $export_process->update(
                    Arr::except($request->all(), ['tags', 'csrf'])
                );
                $tags = $request->get('tags');
                $tags = collect($tags)->map(function ($tag) {
                    return $tag['id'];
                });
                $export_process->content->tags()->sync($tags);
                DB::commit();
                return redirect(route('export-process-management-page'));
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
            return Inertia::render('CMS/ExportProcess/ExportProcessManagement', $data);
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
                        ->whereHasMorph('contentable', [ExportProcess::class])
                        ->withTrashed()
                        ->unPublished()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [ExportProcess::class])
                        ->sortBy($sortingColumn, $sortingDirection, ExportProcess::class)
                        ->paginate($pageSize);
                    break;
                case 2: //published
                    $result = Content::with(['contentable', 'tags'])
                        ->whereHasMorph('contentable', [ExportProcess::class])
                        ->withTrashed()
                        ->publishedWithoutArchived()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [ExportProcess::class])
                        ->sortBy($sortingColumn, $sortingDirection, ExportProcess::class)
                        ->paginate($pageSize);
                    break;
                case 3: //archived
                    $result = Content::with(['contentable','tags'])
                        ->whereHasMorph('contentable', [ExportProcess::class])
                        ->withTrashed()
                        ->archived()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [ExportProcess::class])
                        ->sortBy($sortingColumn, $sortingDirection, ExportProcess::class)
                        ->paginate($pageSize);
                    break;
                default: //any
                    $result = Content::with(['contentable', 'tags'])
                        ->whereHasMorph('contentable', [ExportProcess::class])
                        ->withTrashed()
                        ->ofLanguage($langId)
                        ->search($searchKeyword, [ExportProcess::class])
                        ->sortBy($sortingColumn, $sortingDirection, ExportProcess::class)
                        ->paginate($pageSize);
                    break;
            }
            return new JsonResponse($result);
        } catch (\Throwable $ex) {
            report($ex);
            return new JsonResponse(getGeneralAdminErrorMessage(), 503);
        }
    }
}
