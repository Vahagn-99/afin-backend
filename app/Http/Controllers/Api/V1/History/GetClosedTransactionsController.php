<?php

namespace App\Http\Controllers\Api\V1\History;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Transaction\FilterRequest;
use App\Http\Resources\Api\V1\Transaction\TransactionResource;
use App\Repositories\Transaction\ClosedTransactionRepositoryInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GetClosedTransactionsController extends Controller
{
    public function __construct(
        private readonly ClosedTransactionRepositoryInterface $repo,
    )
    {
    }

    public function __invoke(FilterRequest $request, int $id): AnonymousResourceCollection
    {
        $data = $this->repo
            ->with(['contact'])
            ->getAllByHistoryId($id, $request->getPaginationDTO(), $request->aggregateFilters());

        return TransactionResource::collection($data);
    }
}
