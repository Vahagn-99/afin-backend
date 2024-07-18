<?php

namespace App\Services\BonusCalculator;

use App\Modules\FilterManager\Filter\FiltersAggregor;

interface ManagerCalculatedBonusRepositoryInterface
{
    public function calculatedByDate(string $date, ?FiltersAggregor $filters = null): array;
}