<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckSchedulerWorksCommand extends Command
{
    protected $signature = 'check-schedule';

    protected $description = 'Command description';

    public function handle(): void
    {
        Log::driver('debug')->info('schedule works :' . now()->format('Y-m-d H:i:s'));
    }
}
