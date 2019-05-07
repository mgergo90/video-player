<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     * @return void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if (method_exists($exception, 'getStatusCode')) {
            return response()->json(['errors' => [
                [
                    'status' => (string)$exception->getStatusCode(),
                    'source' => ['pointer' => 'data.attributes'],
                    'detail' => $exception->getMessage(),
                ]
            ]], $exception->getStatusCode());
        } elseif ($exception instanceof AuthorizationException) {
            return response()->json(['errors' => [
                [
                    'status' => (string)JsonResponse::HTTP_UNAUTHORIZED,
                    'source' => ['pointer' => 'data.attributes'],
                    'detail' => $exception->getMessage(),
                ]
            ]], JsonResponse::HTTP_UNAUTHORIZED);
        } elseif ($exception instanceof ModelNotFoundException) {
            return response()->json(['errors' => [
                [
                    'status' => (string)JsonResponse::HTTP_NOT_FOUND,
                    'source' => ['pointer' => 'data.attributes'],
                    'detail' => 'Resource not found',
                ]
            ]], JsonResponse::HTTP_NOT_FOUND);
        }

        return parent::render($request, $exception);
    }
}
