<?php

use App\Http\Middleware\BasicAuthMiddleware;
use App\Modules\FilterManager\Provider\FilterManagerServiceProvider;
use App\Providers\AmoCRMServiceProvider;
use App\Providers\CustomServicesProvider;
use App\Providers\FileManagerServiceProvider;
use App\Providers\PaginatorManagerServiceProvider;
use App\Providers\RepositoryServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web/web.php',
        api: [
            __DIR__ . '/../routes/api/v1/auth.php',
            __DIR__ . '/../routes/api/v1/api.php',
        ],
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth.basic' => BasicAuthMiddleware::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->withProviders([
        AmoCRMServiceProvider::class,
        FileManagerServiceProvider::class,
        CustomServicesProvider::class,
        RepositoryServiceProvider::class,
        FilterManagerServiceProvider::class,
        PaginatorManagerServiceProvider::class
    ])
    ->create();
