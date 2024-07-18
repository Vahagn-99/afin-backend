<?php

namespace App\Providers;

use App\Modules\FileManager\FileManager;
use App\Modules\FileManager\FileManagerInterface;
use Illuminate\Support\ServiceProvider;

class FileManagerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(FileManagerInterface::class, FileManager::class);
        $this->app->bind('filer', FileManagerInterface::class);
    }
}
