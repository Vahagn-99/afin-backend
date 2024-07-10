<?php

namespace App\Http\Controllers\Api\V1\History;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Transaction\FilterRequest;
use App\Http\Resources\Api\V1\Transaction\TransactionResourceFromCollection;
use App\Repositories\Transaction\ClosedTransactionRepositoryInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GetClosedTransactionsController extends Controller
{
    public function __construct(
        private readonly ClosedTransactionRepositoryInterface $closedRepository,
    )
    {
    }

    public function __invoke(FilterRequest $request, int $id): AnonymousResourceCollection
    {
        return TransactionResourceFromCollection::collection($this->closedRepository->getAllByHistoryId($id, $request->getPaginationDTO(), $request->aggregateFilters()));
    }
}
