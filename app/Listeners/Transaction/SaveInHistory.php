<?php

namespace App\Listeners\Transaction;

use App\DTO\SaveTransactionHistoryDTO;
use App\Events\Transaction\MonthClosed;
use App\Repositories\History\TransactionHistoryRepositoryInterface;
use Illuminate\Support\Carbon;

readonly class SaveInHistory
{
    public function __construct(private TransactionHistoryRepositoryInterface $repo)
    {
    }

    public function handle(MonthClosed $event): void
    {
        $closedMonth = Carbon::create($event->month);
        $this->repo->save(new SaveTransactionHistoryDTO(
            from: $closedMonth->startOfMonth()->format("Y-m-d H:i:s"),
            to: $closedMonth->endOfMonth()->format("Y-m-d H:i:s"),
            path: $event->path
        ));
    }
}
