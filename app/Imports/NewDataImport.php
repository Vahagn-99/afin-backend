<?php

namespace App\Imports;

use App\DTO\RateDTO;
use App\Imports\Sheets\ClosedPositionsSheet;
use App\Imports\Sheets\OpenedPositionsSheet;
use App\Imports\Sheets\TransactionSheet;
use App\Models\ImportStatus;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\BeforeImport;

class NewDataImport implements ShouldQueue, WithChunkReading, WithMultipleSheets, SkipsUnknownSheets, WithEvents
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
            'PL' => new TransactionSheet($this->currencies),
            'Opened positions' => new OpenedPositionsSheet(),
            'Closed positions' => new ClosedPositionsSheet(),
        ];
    }

    public function onUnknownSheet($sheetName): void
    {
        // E.g. you can log that a sheet was not found.
        info("Sheet $sheetName was skipped");
    }

    public function beforeImport(BeforeImport $event): void
    {
        $this->progressId = uniqid();

        ImportStatus::importStarted($this->progressId);
    }

    public function afterImport(AfterImport $event): void
    {
        ImportStatus::importCompleted($this->progressId);
    }

    public function importFailed(AfterImport $event): void
    {
        ImportStatus::importFailed($this->progressId);
    }
}
