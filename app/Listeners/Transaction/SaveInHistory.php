<?php

namespace App\Listeners\Transaction;

use App\DTO\SaveTransactionHistoryDTO;
use App\Events\Transaction\MonthClosed;
use App\Repositories\History\TransactionHistoryRepositoryInterface;
use App\Repositories\Transaction\ClosedTransactionRepositoryInterface;
use Illuminate\Support\Carbon;

readonly class SaveInHistory
{
    public function __construct(
        private TransactionHistoryRepositoryInterface $transactionHistoryRepository,
        private ClosedTransactionRepositoryInterface  $closedTransactionRepository
    )
    {
    }

    public function handle(MonthClosed $event): void
    {
        $closedMonth = Carbon::create($event->closedAt);
        $created_at = Carbon::create($event->transactions['0']['created_at']);
        $historyId = $this->transactionHistoryRepository->save(new SaveTransactionHistoryDTO(
            from: $created_at->startOfMonth()->format("Y-m-d H:i:s"),
            to: $created_at->endOfMonth()->format("Y-m-d H:i:s"),
            closet_at: $closedMonth
        ));

        $this->closedTransactionRepository->saveBatchByHistoryId($historyId, $event->transactions);
    }
}
