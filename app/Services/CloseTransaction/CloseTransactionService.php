<?php

namespace App\Services\CloseTransaction;

use App\DTO\CloseTransactionsMonthDTO;
use App\Events\Transaction\MonthClosed;
use App\Repositories\Transaction\DatabaseTransactionRepositoryInterface;

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
        $this->repository->truncate();
        MonthClosed::dispatch($dto->closedAt, $transactions);
    }
}
