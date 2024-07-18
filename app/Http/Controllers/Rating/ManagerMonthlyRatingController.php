<?php

namespace App\Http\Controllers\Rating;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\ManagerRating\ManagerWithRatingResource;
use App\Modules\FilterManager\Filter\FiltersAggregor;
use App\Modules\FilterManager\Filter\MakeFilterDTO;
use App\Modules\FilterManager\Request\FilterRequest;
use App\Repositories\ManagerRating\ManagerMonthlyRatingRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ManagerMonthlyRatingController extends Controller
{
    public function __construct(private readonly ManagerMonthlyRatingRepository $repo)
    {
    }

    public function __invoke(FilterRequest $request, string $month): AnonymousResourceCollection
    {
        $filter = $request->aggregateFilters() ?: new FiltersAggregor();
        $filter->addFilter(new MakeFilterDTO('month', $month));

        $data = $this->repo->ratings($request->getPaginationDTO(), $filter);
        return ManagerWithRatingResource::collection($data);
    }
}
