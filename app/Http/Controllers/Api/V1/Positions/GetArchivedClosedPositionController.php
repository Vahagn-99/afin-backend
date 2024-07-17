<?php

namespace App\Http\Controllers\Api\V1\Positions;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Position\ClosedPositionCollectionResource;
use App\Http\Resources\Api\V1\Position\OpenedPositionCollectionResource;
use App\Modules\FilterManager\Compare\MakeComparingDTO;
use App\Modules\FilterManager\Filter\MakeFilterDTO;
use App\Modules\FilterManager\Request\FilterRequest;
use App\Repositories\Position\ArchivedPositionRepositoryInterface;
use App\Repositories\Position\PositionRepositoryInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GetArchivedClosedPositionController extends Controller
{
    public function __construct(private readonly ArchivedPositionRepositoryInterface $repo)
    {
    }

    public function __invoke(FilterRequest $request, int $history): AnonymousResourceCollection
    {
        $aggregator = $request->aggregateFilters();
        $aggregator->addComparing(new MakeComparingDTO('closed_at', '!=', NULL));
        $aggregator->addFilter(new MakeFilterDTO('archive_id', $history));
        $data = $this->repo
            ->with(['contact' => fn($query) => $query->with('manager')])
            ->paginateWithFilter($request->getPaginationDTO(), $aggregator);

        return ClosedPositionCollectionResource::collection($data);
    }
}
