<?php

namespace App\Repositories\Transaction;

use App\Modules\FilterManager\Filter\FiltersAggregor;

interface CalculateInterface
{
    public function calculate(?FiltersAggregor $filters = null): array;
}