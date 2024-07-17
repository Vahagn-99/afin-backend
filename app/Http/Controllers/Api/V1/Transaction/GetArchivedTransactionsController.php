<?php

namespace App\Http\Controllers\Api\V1\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Transaction\TransactionResource;
use App\Modules\FilterManager\Request\FilterRequest;
use App\Repositories\ArchivedTransaction\ArchivedTransactionRepositoryInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GetArchivedTransactionsController extends Controller
{
    public function __construct(
        private readonly ArchivedTransactionRepositoryInterface $repo,
    )
    {
    }

    public function __invoke(FilterRequest $request, int $id): AnonymousResourceCollection
    {
        $data = $this->repo
            ->with(['contact' => fn($query) => $query->with('manager')])
            ->getAllByHistoryId($id, $request->getPaginationDTO(), $request->aggregateFilters());

        return TransactionResource::collection($data);
    }
}
