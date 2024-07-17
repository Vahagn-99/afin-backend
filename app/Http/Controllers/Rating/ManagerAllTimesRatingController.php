<?php

namespace App\Http\Controllers\Rating;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\ManagerRating\ManagerWithRatingResource;
use App\Modules\FilterManager\Request\FilterRequest;
use App\Repositories\ManagerRating\ManagerAllTimesRatingRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ManagerAllTimesRatingController extends Controller
{
    public function __construct(private readonly ManagerAllTimesRatingRepository $repo)
    {
    }

    public function __invoke(FilterRequest $request): AnonymousResourceCollection
    {
        $data = $this->repo->ratings($request->getPaginationDTO(), $request->aggregateFilters());
        return ManagerWithRatingResource::collection($data);
    }
}
