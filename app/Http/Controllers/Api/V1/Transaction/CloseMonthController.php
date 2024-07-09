<?php

namespace App\Http\Controllers\Api\V1\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Transaction\CloseTransactionsMonthRequest;
use App\Services\CloseTransaction\CloseTransactionServiceInterface;
use Illuminate\Http\JsonResponse;

class CloseMonthController extends Controller
{
    public function __construct(
        private readonly CloseTransactionServiceInterface $closeTransactionService)
    {
    }

    public function __invoke(CloseTransactionsMonthRequest $request): JsonResponse
    {
        $this->closeTransactionService->closeTransaction($request->toDTO());

        return response()->json(['message' => 'Transaction closed by month successfully'], 201);
    }
}
