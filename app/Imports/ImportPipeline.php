<?php

namespace App\Imports;

use App\DTO\RateDTO;
use App\Imports\Sheets\ClosedPositionSheetImport;
use App\Imports\Sheets\OpenedPositionSheetImport;
use App\Imports\Sheets\TransactionSheetImport;
use App\Jobs\Contact\ProcessSyncUnknownContactJob;
use App\Models\ImportStatus;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\BeforeImport;

class ImportPipeline implements ShouldQueue, WithChunkReading, WithMultipleSheets, SkipsUnknownSheets, WithEvents
{
    use RegistersEventListeners;

    protected string $progressId;

    public function __construct(private readonly RateDTO $currencies)
    {
    }

    public function chunkSize(): int
    {
        return 5000;
    }

    public function sheets(): array
    {
        return [
            'PL' => new TransactionSheetImport($this->currencies),
            'Opened positions' => new OpenedPositionSheetImport(),
            'Closed positions' => new ClosedPositionSheetImport(),
        ];
    }

    public function onUnknownSheet($sheetName): void
    {
        // E.g. you can log that a sheet was not found.
        info("Sheet $sheetName was skipped");
    }

    // hooks
    public function beforeImport(BeforeImport $event): void
    {
        $this->progressId = uniqid();
        ImportStatus::importStarted($this->progressId);
    }

    public function afterImport(AfterImport $event): void
    {
        ImportStatus::importCompleted($this->progressId);
    }

    public function importFailed($event): void
    {
        ImportStatus::importFailed($this->progressId);
    }

    public function afterChunk($event): void
    {
        ProcessSyncUnknownContactJob::dispatch();
    }
}
