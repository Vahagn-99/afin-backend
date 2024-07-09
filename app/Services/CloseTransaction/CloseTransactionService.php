<?php

namespace App\Services\CloseTransaction;

use App\DTO\CloseTransactionsMonthDTO;
use App\Jobs\Transaction\ProcessSaveTransactionsInJsonFile;
use App\Repositories\Transaction\DatabaseTransactionRepositoryInterface;
use Illuminate\Support\Arr;

readonly class CloseTransactionService implements CloseTransactionServiceInterface
{
    public function __construct(
        private DatabaseTransactionRepositoryInterface $repository,
    )
    {
    }

    public function closeTransaction(CloseTransactionsMonthDTO $dto): void
    {
        $transactions = $this->repository->getAll();
        $this->repository->truncate(Arr::pluck($transactions, 'id'));

        ProcessSaveTransactionsInJsonFile::dispatch($transactions, $dto->date);
    }
}
