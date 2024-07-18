<?php

namespace App\Http\Controllers\Rating;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\ManagerRating\ManagerWithRatingResource;
use App\Modules\FilterManager\Filter\FiltersAggregor;
use App\Modules\FilterManager\Filter\MakeFilterDTO;
use App\Modules\FilterManager\Request\FilterRequest;
use App\Repositories\ManagerRating\ManagerYearlyRatingRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ManagerYearlyRatingController extends Controller
{
    public function __construct(private readonly ManagerYearlyRatingRepository $repo)
    {
    }

    public function __invoke(FilterRequest $request, string $year): AnonymousResourceCollection
    {
        $filter = $request->aggregateFilters() ?: new FiltersAggregor();
        $filter->addFilter(new MakeFilterDTO('year', $year));

        $data = $this->repo->ratings($request->getPaginationDTO(), $filter);
        return ManagerWithRatingResource::collection($data);
    }
}
