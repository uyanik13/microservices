<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

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
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }


 /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        return parent::render($request, $exception);
    }

    protected function renderHttpException(HttpExceptionInterface $e)
    {
        if ($e instanceof NotFoundHttpException) {
            return response()->json([
                'status' => trans('api.not_found'),
                'locale' => app()->getLocale(),
                'errors' => true,
                'data' => [
                    'message' => trans('api.endpoint_not_found'),
                ]
            ], JsonResponse::HTTP_NOT_FOUND);
        }
        if ($e instanceof MethodNotAllowedHttpException) {
            return response()->json([
                'status' => trans('api.not_found'),
                'locale' => app()->getLocale(),
                'errors' => true,
                'data' => [
                    'message' => trans('api.http_method_not_allowed'),
                ]
            ], JsonResponse::HTTP_METHOD_NOT_ALLOWED);
        }
        if ($e instanceof AuthenticationException ) {
            return response()->json([
                'status' => trans('api.unauthorized'),
                'locale' => app()->getLocale(),
                'errors' => true,
                'data' => [
                    'message' => trans('api.http_method_not_allowed'),
                ]
            ], JsonResponse::HTTP_FORBIDDEN);
        }
        if ($e instanceof UnauthorizedHttpException) {
            return response()->json([
                'status' => trans('api.unauthorized'),
                'locale' => app()->getLocale(),
                'errors' => true,
                'data' => [
                    'message' => trans('api.unauthorized'),
                ]
            ], JsonResponse::HTTP_FORBIDDEN);
        }

        return response()->json([
            'status' => trans('api.bad_request'),
            'locale' => app()->getLocale(),
            'errors' => true,
            'data' => [
                'message' => trans('api.bad_request'),
            ]
        ], JsonResponse::HTTP_FORBIDDEN);
    }

}
