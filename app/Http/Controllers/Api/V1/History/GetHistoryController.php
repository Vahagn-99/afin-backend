<?php

namespace App\Http\Controllers\Api\V1\History;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\History\GetHistoryRequest;
use App\Http\Resources\Api\V1\Transaction\TransactionResourceFromArray;
use App\Modules\PaginatorManager\Paginator;
use App\Repositories\History\TransactionHistoryRepositoryInterface;
use App\Repositories\Transaction\FileSystemTransactionRepositoryInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GetHistoryController extends Controller
{
    public function __construct(
        private readonly FileSystemTransactionRepositoryInterface $repo,
        private readonly TransactionHistoryRepositoryInterface    $historyRepository,
    )
    {
    }

    public function __invoke(GetHistoryRequest $request, int $id): AnonymousResourceCollection
    {
        $history = $this->historyRepository->get($id);

        return TransactionResourceFromArray::collection(Paginator::paginate($this->repo->getTransactionsByJsonFilePath($history['path']), $request->getPaginationDTO()));
    }
}
