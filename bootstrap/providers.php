<?php

return [
    App\Console\Scheduler::class,
    App\Modules\AmoCRM\Core\Providers\AmoCRMServiceProvider::class,
    App\Providers\AppServiceProvider::class,
    App\Providers\CustomServicesProvider::class,
    \App\Modules\FilterManager\Provider\FilterValidationRulesProvider::class,
    App\Providers\FileManagerServiceProvider::class,
    App\Providers\HorizonServiceProvider::class,
    App\Providers\ImportManagerServiceProvider::class,
    App\Providers\JsonTransactionManagerServiceProvider::class,
    App\Providers\PaginatorManagerServiceProvider::class,
    App\Providers\RepositoryServiceProvider::class,
];
