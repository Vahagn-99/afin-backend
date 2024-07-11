<?php

namespace App\Http\Controllers\Api\V1\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Transaction\FilterRequest;
use App\Http\Resources\Api\V1\Transaction\TransactionResource;
use App\Repositories\Core\TransactionRepositoryInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GetTransactionListController extends Controller
{
    public function __construct(
        private readonly TransactionRepositoryInterface $repo
    )
    {
    }

    public function __invoke(FilterRequest $request): AnonymousResourceCollection
    {
        $data = $this->repo
            ->with(['contact'])
            ->paginateWithFilter($request->getPaginationDTO(), $request->aggregateFilters());
        return TransactionResource::collection($data);
    }
}
