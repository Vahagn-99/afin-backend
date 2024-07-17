<?php

namespace App\Http\Controllers\Api\V1\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Transaction\TransactionResource;
use App\Modules\FilterManager\Request\FilterRequest;
use App\Repositories\Transaction\TransactionRepositoryInterface;
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
            ->with(['contact' => fn($query) => $query->with('manager')])
            ->paginateWithFilter($request->getPaginationDTO(), $request->aggregateFilters());
        return TransactionResource::collection($data);
    }
}
