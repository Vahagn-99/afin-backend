<?php

namespace App\Http\Controllers\Api\V1\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Transaction\FilterRequest;
use App\Http\Resources\Api\V1\Transaction\TransactionResourceFromCollection;
use App\Repositories\Core\DatabasePaginatedTransactionRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GetTransactionListController extends Controller
{
    public function __construct(
        private readonly DatabasePaginatedTransactionRepository $repo
    )
    {
    }

    public function __invoke(FilterRequest $request): AnonymousResourceCollection
    {
        return TransactionResourceFromCollection::collection($this->repo->paginated($request->aggregateFilters(), $request->getPaginationDTO()));
    }
}
