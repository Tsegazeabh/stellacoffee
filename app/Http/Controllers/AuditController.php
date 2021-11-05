<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Inertia\Inertia;
use App\Models\Audit;

class AuditController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        try {
            $data['pagingSize'] = getDefaultPagingSize();
            return Inertia::render('CMS/Audits/Index', $data);
        } catch (\Throwable $ex) {
            report($ex);
            if ($ex instanceof AuthorizationException) {
                abort(403);
            }

            return response(getGeneralAdminErrorMessage(), 503);
        }
    }

    public function fetchAudits(Request $request)
    {
        try {
            $model = null;
            $action = null;
            $date_from = null;
            $date_to = null;
            if ($request->has('simpleFilters')) {
                $model = Arr::exists($request->get('simpleFilters'), 'model') ? $request->get('simpleFilters')['model'] : null;
                $action = Arr::exists($request->get('simpleFilters'), 'action') ? $request->get('simpleFilters')['action'] : null;
                $date_from = array_key_exists( 'from', $request->get('simpleFilters')) ? Carbon::createFromFormat('Y-m-d h:i A', $request->get('simpleFilters')['from']) : null;
                $date_to = array_key_exists( 'upto', $request->get('simpleFilters')) ? Carbon::createFromFormat('Y-m-d h:i A', $request->get('simpleFilters')['upto']) : null;
            }

            $request['page'] = $request->get('currentPage') + 1;
            $pageSize = $request->get('pageSize', getDefaultPagingSize());
            $sortingColumn = $request->get('sortingColumn');
            $sortingDirection = $request->get('sortingDirection', getDefaultSortingMethod());

            if (mb_strlen($sortingColumn) == 0) {
                $sortingColumn = getDefaultSortingColumn();
            }

            $audits = Audit::with('user')
                ->when(mb_strlen($model) > 0, function ($query) use ($model) {
                    return $query->where('auditable_type', $model);
                })
                ->when(mb_strlen($action) > 0, function ($query) use ($action) {
                    return $query->where('event', $action);
                })
                ->when(mb_strlen($date_from) > 0, function ($query) use ($date_from) {
                    return $query->where('created_at','>=', $date_from);
                })
                ->when(mb_strlen($date_to) > 0, function ($query) use ($date_to) {
                    return $query->where('created_at','<=', $date_to);
                })->orderBy($sortingColumn, $sortingDirection)->paginate($pageSize);

            return response($audits);
        } catch (\Throwable $ex) {
            report($ex);
            if ($ex instanceof AuthorizationException) {
                abort(403);
            }

            return response(getGeneralAdminErrorMessage(), 503);
        }
    }

    public function detail(Request $request, $id)
    {
        try {
            $audit = Audit::with('user')->find($id);
            if (!empty($audit)) {
                $data['audit'] = $audit;
                return Inertia::render('CMS/Audits/Detail', $data);
            } else {
                abort(404);
            }
        } catch (\Throwable $ex) {
            report($ex);
            if ($ex instanceof AuthorizationException) {
                abort(403);
            }

            return response(getGeneralAdminErrorMessage(), 503);
        }
    }

    protected function getAuditedModels()
    {
        try {
            $models = Audit::select('auditable_type')->distinct()->get();
            $model_arr = $models->map(function ($model) {
                return [
                    'system_name' => $model->auditable_type,
                    'short_name' => $model->auditable_type_model_name
                ];
            });
            return response($model_arr, 200);
        } catch (\Throwable $ex) {
            logError($ex);
            if ($ex instanceof AuthorizationException) {
                abort(403);
            }
            return response(getGeneralAdminErrorMessage(), 503);
        }
    }
}
