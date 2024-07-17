<?php

namespace App\Http\Controllers\Api\V1\Contact;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Contact\ContactResource;
use App\Modules\FilterManager\Request\FilterRequest;
use App\Repositories\Contact\ContactRepositoryInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GetContactController extends Controller
{
    public function __construct(
        private readonly ContactRepositoryInterface $repo
    )
    {
    }

    public function __invoke(FilterRequest $request): AnonymousResourceCollection
    {
        $this->repo->with(['manager']);
        return ContactResource::collection($this->repo->paginateWithFilter(
            $request->getPaginationDTO(),
            $request->aggregateFilters())
        );
    }
}
