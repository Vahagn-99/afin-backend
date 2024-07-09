<?php

namespace App\Imports;

use App\DTO\RateDTO;
use App\Imports\Sheets\ClosedPositionsSheet;
use App\Imports\Sheets\OpenedPositionsSheet;
use App\Imports\Sheets\TransactionSheet;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

readonly class NewDataImport
    implements ShouldQueue,
    WithChunkReading,
    WithMultipleSheets,
    SkipsUnknownSheets
{
    public function __construct(private RateDTO $currencies)
    {
    }

    public function chunkSize(): int
    {
        return 1000;
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
}
