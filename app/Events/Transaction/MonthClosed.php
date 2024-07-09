<?php

namespace App\Events\Transaction;

use Illuminate\Foundation\Events\Dispatchable;

class MonthClosed
{
    use Dispatchable;

    public function __construct(public readonly string $month, public readonly string $path)
    {
    }
}
