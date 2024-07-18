<?php

namespace App\Http\Controllers\Bonus;

use App\Http\Controllers\Controller;
use App\Modules\FilterManager\Request\FilterRequest;
use App\Repositories\ManagerBonus\ManagerBonusRepositoryInterface;
use Illuminate\Http\JsonResponse;

class ManagerBonusController extends Controller
{
    public function __construct(
        private readonly ManagerBonusRepositoryInterface $managerBonusRepository
    )
    {
    }

    public function __invoke(FilterRequest $request): JsonResponse
    {
        $data = $this->managerBonusRepository->getAll($request->aggregateFilters());
        return response()->json($data);
    }
}
