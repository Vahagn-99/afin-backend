<?php

namespace App\Http\Controllers\Bonus;

use App\Http\Controllers\Controller;
use App\Modules\FilterManager\Request\FilterRequest;
use App\Services\BonusCalculator\ManagerCalculatedBonusRepositoryInterface;
use Illuminate\Http\JsonResponse;

class ManagerCurrentMonthBonusController extends Controller
{
    public function __construct(
        private readonly ManagerCalculatedBonusRepositoryInterface $bonusCalculator
    )
    {
    }

    public function __invoke(FilterRequest $request): JsonResponse
    {
        $data = $this->bonusCalculator->calculatedByDate(now()->format('Y-m-d'), $request->aggregateFilters());
        return response()->json($data);
    }
}
