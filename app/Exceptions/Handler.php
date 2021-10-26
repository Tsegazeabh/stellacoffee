<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\MultipleRecordsFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Exception\SuspiciousOperationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthenticationException::class,
        AuthorizationException::class,
        HttpException::class,
        HttpResponseException::class,
        ModelNotFoundException::class,
        MultipleRecordsFoundException::class,
        RecordsNotFoundException::class,
        SuspiciousOperationException::class,
        TokenMismatchException::class,
        ValidationException::class,
        QueryException::class
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (NotFoundHttpException $e, $request) {
            logError($e);
            if($e instanceof NotFoundHttpException || $e instanceof ModelNotFoundException) {
                return Inertia::render('Errors/404');
            }
            else if($e instanceof AuthorizationException) {
                return Inertia::render('Errors/403');
            }
            else if($e instanceof QueryException) {
                return Inertia::render('Errors/QueryException');
            }
        });

        $this->reportable(function (Throwable $e) {
        });
    }

    public function render($request, Throwable $e)
    {
        if (app()->isDownForMaintenance()) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'The site is currently down for maintenance, please check back with us soon'], 503);
            } else {
                return response()->view('errors.maintenance_mode', [], 503);
            }
        }
        return parent::render($request, $e);
    }
}
