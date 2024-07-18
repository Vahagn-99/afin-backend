<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Maatwebsite\Excel\Sheet;

class ImportManagerServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Sheet::macro('size', function (Sheet $sheet) {
           return $sheet->getChartCount();
        });
    }
}
