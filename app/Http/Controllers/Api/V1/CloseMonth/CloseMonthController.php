<?php

namespace App\Http\Controllers\Api\V1\CloseMonth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\CloseMonth\CloseMonthRequest;
use App\Jobs\CloseMonth\ProcessCalculateBonusForClosedMonth;
use App\Jobs\CloseMonth\ProcessCalculateRatingForClosedMonth;
use App\Jobs\CloseMonth\ProcessArchivedTransctionsAndPositionsForClosedMonth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Bus;
use Throwable;

class CloseMonthController extends Controller
{
    /**
     * @throws Throwable
     */
    public function __invoke(CloseMonthRequest $request): JsonResponse
    {
        $month = $request->toDTO();
        Bus::chain([
            new ProcessCalculateBonusForClosedMonth($month),
            new ProcessArchivedTransctionsAndPositionsForClosedMonth($month),
            new ProcessCalculateRatingForClosedMonth($month),
        ])->dispatch();

        return response()->json(
            ['message' => 'processing! please wait...'],
            201
        );
    }
}
