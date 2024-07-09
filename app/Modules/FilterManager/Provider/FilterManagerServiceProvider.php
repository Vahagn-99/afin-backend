<?php

namespace App\Modules\FilterManager\Provider;

use App\Modules\FilterManager\Console\Command\MakeFilterCommand;
use App\Modules\FilterManager\FilterManager;
use App\Modules\FilterManager\Interfaces\FilterManagerInterface;
use Illuminate\Support\ServiceProvider;

class FilterManagerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(FilterManagerInterface::class, FilterManager::class);
        $this->app->bind('filter', FilterManagerInterface::class);
    }

    public function boot(): void
    {
        $this->commands([
            MakeFilterCommand::class
        ]);
    }
}
