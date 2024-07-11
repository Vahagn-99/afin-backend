<?php

namespace App\Imports\Sheets;

use App\DTO\RateDTO;
use App\Services\Deposit\ConvertableDTO;
use App\Services\Deposit\Converter;
use Exception;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

readonly class TransactionSheetImport implements ToArray, SkipsEmptyRows, WithHeadingRow
{

    public function __construct(private RateDTO $currencyRates)
    {
    }

    public function array(array $array): void
    {
        $mappedRows = [];
        foreach ($array as $row) {
            $this->mapData($row);
            $mappedRows[] = $row;
        }
        DB::table('transactions')->upsert($mappedRows, 'login');
    }

    private function mapData(array &$row): void
    {
        try {

            $row = [
                "login" => (int)$row['Login'],
                "lk" => (int)$row['LK'],
                "currency" => $row['Currency'],
                "deposit" => Converter::convert(new ConvertableDTO($row['Deposit'], $row['Currency'], $this->currencyRates)),
                "withdrawal" => $row['Withdrawal'],
                "volume_lots" => $row['Volume Lots'],
                "equity" => $row['Equity 30.04'],
                "balance_start" => $row['Balance 01.04'],
                "balance_end" => $row['Balance 30.04'],
                "commission" => $row['P/L (+Commission)']
            ];
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }
}