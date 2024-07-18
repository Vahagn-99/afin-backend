<?php

namespace App\Http\Controllers\Api\V1\Archive;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Archive\ArchiveCollectionResource;
use App\Modules\FilterManager\Request\FilterRequest;
use App\Repositories\Archive\ArchiveRepositoryInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GeArchivesController extends Controller
{
    public function __construct(
        private readonly ArchiveRepositoryInterface $repo
    )
    {
    }

    public function __invoke(FilterRequest $request): AnonymousResourceCollection
    {
        return ArchiveCollectionResource::collection($this->repo->paginateWithFilter($request->getPaginationDTO(), $request->aggregateFilters()));
    }
}
