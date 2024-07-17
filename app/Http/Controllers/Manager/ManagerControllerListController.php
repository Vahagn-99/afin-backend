<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Manager\ManagerResource;
use App\Modules\FilterManager\Request\FilterRequest;
use App\Repositories\Manager\ManagerRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ManagerControllerListController extends Controller
{
    public function __construct(private readonly ManagerRepositoryInterface $managerRepository)
    {
    }

    public function __invoke(FilterRequest $request): AnonymousResourceCollection
    {
        return ManagerResource::collection($this->managerRepository->getAll($request->aggregateFilters()));
    }
}
