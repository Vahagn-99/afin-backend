<?php

use App\Console\Scheduler;
use App\Http\Middleware\BasicAuthMiddleware;
use App\Modules\AmoCRM\Core\Providers\AmoCRMServiceProvider;
use App\Modules\FilterManager\Provider\FilterValidationRulesProvider;
use App\Modules\FilterManager\Provider\FilterManagerServiceProvider;
use App\Providers\CustomServicesProvider;
use App\Providers\FileManagerServiceProvider;
use App\Providers\HorizonServiceProvider;
use App\Providers\ImportManagerServiceProvider;
use App\Providers\PaginatorManagerServiceProvider;
use App\Providers\RepositoryServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: [
            __DIR__ . '/../routes/web/web.php',
            __DIR__ . '/../routes/external/amocrm.php',
        ],
        api: [
            __DIR__ . '/../routes/api/api.php',
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
        Scheduler::class,
        HorizonServiceProvider::class,
        AmoCRMServiceProvider::class,
        FileManagerServiceProvider::class,
        CustomServicesProvider::class,
        RepositoryServiceProvider::class,
        FilterManagerServiceProvider::class,
        PaginatorManagerServiceProvider::class,
        ImportManagerServiceProvider::class,
        FilterValidationRulesProvider::class
    ])
    ->create();
