<?php

namespace App\Http\Controllers\Rating;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\ManagerRating\RatingHistoryResource;
use App\Modules\FilterManager\Request\FilterRequest;
use App\Repositories\ManagerRating\ManagerRatingHistoryRepositoryInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ManagerRatingHistoriesController extends Controller
{
    public function __construct(private readonly ManagerRatingHistoryRepositoryInterface $repo)
    {
    }

    public function __invoke(FilterRequest $request): AnonymousResourceCollection
    {
        $data = $this->repo->paginateWithFilter($request->getPaginationDTO());
        return RatingHistoryResource::collection($data);
    }
}
