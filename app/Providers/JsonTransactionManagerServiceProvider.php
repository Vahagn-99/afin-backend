<?php

namespace App\Providers;

use App\Modules\JsonManager\JsonTransactionManager;
use App\Modules\JsonManager\JsonTransactionManagerInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;

class JsonTransactionManagerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $disk = $this->app->environment('testing') ? 'testing' : 'history';

        $this->app->bind(JsonTransactionManagerInterface::class, function () use ($disk) {
            return new JsonTransactionManager(Storage::disk($disk));
        });

        $this->app->bind('JsonManager', JsonTransactionManagerInterface::class);
    }
}
