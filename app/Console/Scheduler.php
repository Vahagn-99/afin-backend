<?php

namespace App\Console;

use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\ServiceProvider;

class Scheduler extends ServiceProvider
{
    public function boot(): void
    {
        Schedule::command('import:test-file')->everyFifteenMinutes();
//        Schedule::command('check-schedule')->everySecond();
        Schedule::command('amo:contacts')->everyFifteenMinutes();
        Schedule::command('amo:managers')->everyFifteenMinutes();
        Schedule::command('managers-ratings-leads')->everyFifteenMinutes();
        Schedule::command('managers-ratings-deposit')->everyFifteenMinutes();
    }
}
