<?php

use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;
use App\Http\Middleware\HandleInertiaRequests;
use App\ValueObjects\Notification;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn(Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            return Inertia::render('Error', [
                'status' => 404,
                'message' => 'Страница не найдена.'
            ])->toResponse($request)->setStatusCode(404);
        });
        $exceptions->render(function (AppException $e, Request $request) {
            if (!$request->hasSession()) {
                $httpCode = match ($e->getCode()) {
                    AppExceptionStatus::INVALID_ARGUMENT => 400,
                    AppExceptionStatus::NOT_FOUND => 404,
                    AppExceptionStatus::ALREADY_EXISTS => 409,
                    AppExceptionStatus::BUSINESS_ERROR => 422,
                    AppExceptionStatus::INTERNAL_ERROR => 500,
                };

                return response()->json(['error' => $e->getMessage()], $httpCode);
            }
            return match ($e->getCode()) {
                AppExceptionStatus::INTERNAL_ERROR,
                AppExceptionStatus::NOT_FOUND,
                AppExceptionStatus::ALREADY_EXISTS,
                AppExceptionStatus::INVALID_ARGUMENT,
                AppExceptionStatus::BUSINESS_ERROR => redirect()
                    ->back()
                    ->withInput()
                    ->with(Notification::fromAppException($e)),

                default => Inertia::render('Errors/Error', [
                    'status' => 500,
                    'message' => 'Произошла неизвестная ошибка.'
                ])->toResponse($request)->setStatusCode(500),
            };
        });
    })->create();
