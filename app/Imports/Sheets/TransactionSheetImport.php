<?php

namespace App\Imports\Sheets;

use App\DTO\RateDTO;
use App\Services\Convertor\ConvertableDTO;
use App\Services\Convertor\Converter;
use Exception;
use Illuminate\Support\Arr;
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
        $equity = current(Arr::where($row, fn($value, $key) => str_contains($key, 'Equity')));
        [$balanceStart, $balanceEnd] = array_values(Arr::where($row, fn($value, $key) => str_contains($key, 'Balance')));
        try {
            $row = [
                "login" => (int)$row['Login'],
                "lk" => (int)$row['LK'],
                "currency" => $row['Currency'],
                "deposit" => $this->convert($row['Deposit'], $row['Currency']),
                "withdrawal" => $row['Withdrawal'],
                "volume_lots" => $row['Volume Lots'],
                "equity" => $this->convert($equity, $row['Currency']),
                "balance_start" => $this->convert($balanceStart, $row['Currency']),
                "balance_end" => $this->convert($balanceEnd, $row['Currency']),
                "commission" => $this->convert($row['P/L (+Commission)'], $row['Currency'])
            ];
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }

    public function convert($amount, $currency): float
    {
        return Converter::convert(new ConvertableDTO($amount, $currency, $this->currencyRates));
    }
}