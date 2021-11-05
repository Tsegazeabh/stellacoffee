<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArchiveRequest;
use App\Http\Resources\ArchivesResource;
use App\Models\Content;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ArchiveController extends Controller
{
    function __construct()
    {
    }
    protected function getIndex(Request $request)
    {
        return Inertia::render('Public/ArchiveSearch/Search');
    }
    protected function getResources()
    {
        try {
            $contentTypes = Content::withTrashed()->archived()->select('contentable_type')->distinct()->pluck('contentable_type');
            $arr = array();
            foreach ($contentTypes as $contentType) {
                $arr[$contentType] = getModelShortName($contentType);
            }
            return response($arr);
        } catch (\Throwable $ex) {
            logError($ex);
            return response(getGeneralAdminErrorMessage(), 503);
        }
    }

    protected function getMonths(Request $request)
    {
        try {
            $months = Content::with('contentable')->whereHas('contentable', function ($query) use ($request) {
                $query->where('contentable_type', $request->get('contentType'));
            })
                ->withTrashed()->archived()->whereYear('published_at', $request->get('year'))
                ->select(DB::raw('MONTH(published_at) as month, monthname(published_at) as monthName'))
                ->distinct()
                ->orderBy('month', 'DESC')
                ->pluck('monthName', 'month');

            return response($months);
        } catch (\Throwable $ex) {
            logError($ex);
            return response(getGeneralAdminErrorMessage(), 503);
        }
    }

    protected function getYears(Request $request)
    {
        try {
            $years = Content::with('contentable')->whereHas('contentable', function ($query) use ($request) {
                $query->where('contentable_type', $request->get('contentType'));
            })
                ->withTrashed()->archived()
                ->select(DB::raw('YEAR(published_at) as year'))
                ->distinct()
                ->orderBy('year', 'DESC')
                ->pluck('year');

            return response($years);

        } catch (\Throwable $ex) {
            logError($ex);
            return response(getGeneralAdminErrorMessage(), 503);
        }
    }

    /**
     * Get specific Archive Details from published bill_information.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    protected function getArchives(Request $request)
    {
        try {

            $langId = getSessionLanguageId();
            $contentType = $request->get('contentType');
            $publishDateMonth = $request->get('publishDateMonth');
            $publishDateYear = $request->get('publishDateYear');

            if ($contentType == null && $publishDateMonth == null && $publishDateYear == null) {
                $archives = Content::with('contentable', 'tags')
                    ->ofLanguage($langId)
                    ->withTrashed()
                    ->archived()
                    ->orderBy('published_at', 'DESC')
                    ->paginate(getDefaultPagingSize());
            } else if ($contentType != null && $publishDateMonth == null && $publishDateYear == null) {
                $archives = Content::with('contentable', 'tags')
                    ->whereHas('contentable', function ($query) use ($contentType) {
                        $query->where('contentable_type', $contentType);
                    })
                    ->ofLanguage($langId)
                    ->withTrashed()
                    ->archived()
                    ->orderBy('published_at', 'DESC')
                    ->paginate(getDefaultPagingSize());
            } else if ($contentType == null && $publishDateMonth != null && $publishDateYear == null) {
                $archives = Content::with('contentable', 'tags')
                    ->ofLanguage($langId)
                    ->withTrashed()
                    ->archived()
                    ->whereMonth('published_at', '=', $publishDateMonth)
                    ->whereYear('published_at', '=', $publishDateYear)
                    ->orderBy('published_at', 'DESC')
                    ->paginate(getDefaultPagingSize());
            } else if ($contentType == null && $publishDateMonth == null && $publishDateYear != null) {
                $archives = Content::with('contentable', 'tags')
                    ->ofLanguage($langId)
                    ->withTrashed()
                    ->archived()
                    ->whereYear('published_at', '=', $publishDateYear)
                    ->orderBy('published_at', 'DESC')
                    ->paginate(getDefaultPagingSize());
            } else if ($contentType == null && $publishDateMonth != null && $publishDateYear != null) {
                $archives = Content::with('contentable', 'tags')
                    ->ofLanguage($langId)
                    ->withTrashed()
                    ->archived()
                    ->whereMonth('published_at', '=', $publishDateMonth)
                    ->whereYear('published_at', '=', $publishDateYear)
                    ->orderBy('published_at', 'DESC')
                    ->paginate(getDefaultPagingSize());
            } else if ($contentType != null && $publishDateMonth != null && $publishDateYear != null) {
                $archives = Content::with('contentable')
                    ->whereHas('contentable', function ($query) use ($contentType) {
                        $query->where('contentable_type', $contentType);
                    })
                    ->ofLanguage($langId)
                    ->withTrashed()
                    ->archived()
                    ->whereMonth('published_at', '=', $publishDateMonth)
                    ->whereYear('published_at', '=', $publishDateYear)
                    ->orderBy('published_at', 'DESC')
                    ->paginate(getDefaultPagingSize());
            } else if ($contentType != null && $publishDateMonth != null && $publishDateYear == null) {
                $archives = Content::with('contentable', 'tags')
                    ->whereHas('contentable', function ($query) use ($contentType) {
                        $query->where('contentable_type', $contentType);
                    })
                    ->ofLanguage($langId)
                    ->withTrashed()
                    ->archived()
                    ->whereMonth('published_at', '=', $publishDateMonth)
                    ->whereYear('published_at', '=', $publishDateYear)
                    ->orderBy('published_at', 'DESC')
                    ->paginate(getDefaultPagingSize());
            } else if ($contentType != null && $publishDateMonth == null && $publishDateYear != null) {
                $archives = Content::with('contentable', 'tags')
                    ->whereHas('contentable', function ($query) use ($contentType) {
                        $query->where('contentable_type', $contentType);
                    })
                    ->ofLanguage($langId)
                    ->withTrashed()
                    ->archived()
                    ->whereYear('published_at', '=', $publishDateYear)
                    ->orderBy('published_at', 'DESC')
                    ->paginate(getDefaultPagingSize());
            } else {
                $archives = Content::with('contentable', 'tags')
                    ->ofLanguage($langId)
                    ->withTrashed()
                    ->archived()
                    ->orderBy('published_at', 'DESC')
                    ->paginate(getDefaultPagingSize());
            }
            return response($archives);
        } catch (\Throwable $ex) {
            logError($ex);
            return new JsonResponse(getGeneralAdminErrorMessage(), 503);
        }
    }
}
