<?php

namespace App\Http\Controllers\Api\V1\Positions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Transaction\FilterRequest;
use App\Http\Resources\Api\V1\Position\OpenedPositionCollectionResource;
use App\Modules\FilterManager\Compare\MakeComparingDTO;
use App\Repositories\Position\PositionPaginatedRepositoryInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GetOpenedPositionController extends Controller
{
    public function __construct(private readonly PositionPaginatedRepositoryInterface $repo)
    {
    }

    public function __invoke(FilterRequest $request): AnonymousResourceCollection
    {
        $aggregator = $request->aggregateFilters();
        $aggregator->addComparing(new MakeComparingDTO('closed_at', '=', NULL));
        return OpenedPositionCollectionResource::collection($this->repo->getAllPaginated($request->getPaginationDTO(), $aggregator));
    }
}
