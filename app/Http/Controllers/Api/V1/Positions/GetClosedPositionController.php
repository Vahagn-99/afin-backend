<?php

namespace App\Http\Controllers\Api\V1\Positions;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Position\ClosedPositionCollectionResource;
use App\Modules\FilterManager\Compare\MakeComparingDTO;
use App\Modules\FilterManager\Request\FilterRequest;
use App\Repositories\Position\PositionRepositoryInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GetClosedPositionController extends Controller
{
    public function __construct(private readonly PositionRepositoryInterface $repo)
    {
    }

    public function __invoke(FilterRequest $request): AnonymousResourceCollection
    {
        $aggregator = $request->aggregateFilters();
        $aggregator->addComparing(new MakeComparingDTO('closed_at', '!=', NULL));
        $data = $this->repo
            ->with(['contact' => fn($query) => $query->with('manager')])
            ->paginateWithFilter($request->getPaginationDTO(), $aggregator);
        return ClosedPositionCollectionResource::collection($data);
    }
}
