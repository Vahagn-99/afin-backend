<?php

namespace App\Jobs\CloseMonth;

use App\DTO\CloseMonthDTO;
use App\Services\CloseTransaction\CloseMonthServiceInterface;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessArchivedTransctionsAndPositionsForClosedMonth implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels,Batchable;


    public function __construct(
        private readonly CloseMonthDTO $closeMonthDTO,
    )
    {
        $this->onQueue('archiving');
        $this->afterCommit();
    }

    public function handle(
        CloseMonthServiceInterface $service
    ): void
    {
        $service->closeMonth($this->closeMonthDTO);
    }
}
