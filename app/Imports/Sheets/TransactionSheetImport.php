<?php

namespace App\Imports\Sheets;

use App\DTO\RateDTO;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

readonly class TransactionSheetImport implements ToArray, SkipsEmptyRows, WithHeadingRow
{
    use HasConvertor;

    public function __construct(private RateDTO $currencyRates)
    {
    }

    public function array(array $array): void
    {
        $mappedRows = [];
        foreach ($array as $row) {
            try {
                $this->mapData($row);
                $mappedRows[] = $row;
            } catch (Exception $e) {
                error_log($e->getMessage());
                continue;
            }
        }
        try {
            DB::table('transactions')->upsert($mappedRows, 'login');
        } catch (Exception $e) {
            logger($e->getMessage(), $mappedRows);
        }
    }

    private function mapData(array &$row): void
    {
        $equity = current(Arr::where($row, fn($value, $key) => str_contains($key, 'Equity')));
        [$balanceStart, $balanceEnd] = array_values(Arr::where($row, fn($value, $key) => str_contains($key, 'Balance')));
        $row = array_filter(
            [
                "login" => (int)$row['Login'],
                "lk" => (int)$row['LK'],
                "currency" => $row['Currency'],
                "deposit" => $this->convert($row['Deposit'], $row['Currency']),
                "withdrawal" => $this->convert($row['Withdrawal'], $row['Currency']),
                "volume_lots" => $row['Volume Lots'],
                "equity" => $this->convert($equity, $row['Currency']),
                "balance_start" => $this->convert($balanceStart, $row['Currency']),
                "balance_end" => $this->convert($balanceEnd, $row['Currency']),
                "commission" => $this->convert($row['P/L (+Commission)'], $row['Currency'])
            ],
            fn($value) => $value || is_numeric($value)
        );
    }
}