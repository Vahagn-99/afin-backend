<?php

namespace App\Providers;

use App\Modules\PaginatorManager\ArrayPaginator;
use App\Modules\PaginatorManager\PaginatorInterface;
use Illuminate\Support\ServiceProvider;

class PaginatorManagerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PaginatorInterface::class, ArrayPaginator::class);
        $this->app->bind('custom_paginator', PaginatorInterface::class);
    }
}
