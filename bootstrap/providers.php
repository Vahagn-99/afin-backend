<?php

return [
    \App\Modules\AmoCRM\Core\Providers\AmoCRMServiceProvider::class,
    App\Providers\AppServiceProvider::class,
    App\Providers\CustomServicesProvider::class,
    App\Providers\FileManagerServiceProvider::class,
    App\Providers\HorizonServiceProvider::class,
    App\Providers\ImportManagerServiceProvider::class,
    App\Providers\JsonTransactionManagerServiceProvider::class,
    App\Providers\PaginatorManagerServiceProvider::class,
    App\Providers\RepositoryServiceProvider::class,
];
