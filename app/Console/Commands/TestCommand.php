<?php

namespace App\Console\Commands;

use App\Services\AmoCRM\Api\ContactApi;
use Illuminate\Console\Command;

class TestCommand extends Command
{
    protected $signature = 'test:service';

    public function handle(ContactApi $contactApi)
    {
        dd($contactApi->list()->toArray());
    }
}
