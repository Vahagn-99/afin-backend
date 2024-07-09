<?php

namespace App\Jobs\Transaction;

use App\Events\Transaction\MonthClosed;
use App\Http\Resources\Api\V1\Transaction\TransactionResourceFromArray;
use App\Modules\JsonManager\Json;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class ProcessSaveTransactionsInJsonFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly array  $transactions,
        private readonly string $date
    )
    {
    }

    public function handle(): void
    {
        $count = Cache::get('count', 0) + 1;
        Cache::set('count', $count);
        $path = Json::save(TransactionResourceFromArray::collection($this->transactions)->jsonSerialize(), $this->date);
        MonthClosed::dispatch($this->date, $path);
    }

}
