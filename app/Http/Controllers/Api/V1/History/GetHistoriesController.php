<?php

namespace App\Http\Controllers\Api\V1\History;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Transaction\FilterRequest;
use App\Http\Resources\Api\V1\History\HistoryCollectionResource;
use App\Repositories\History\TransactionHistoryRepositoryInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GetHistoriesController extends Controller
{
    public function __construct(
        private readonly TransactionHistoryRepositoryInterface $repo
    )
    {
    }

    public function __invoke(FilterRequest $request): AnonymousResourceCollection
    {
        return HistoryCollectionResource::collection($this->repo->paginateWithFilter($request->getPaginationDTO(), $request->aggregateFilters()));
    }
}
