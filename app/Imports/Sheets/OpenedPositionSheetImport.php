<?php

namespace App\Imports\Sheets;

use App\DTO\RateDTO;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

readonly class OpenedPositionSheetImport implements ToArray, SkipsEmptyRows, WithHeadingRow
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

            DB::table('positions')->upsert($mappedRows, ['login', 'position']);
        } catch (Exception $e) {
            logger($e->getMessage(), $mappedRows);
        }
    }

    private function mapData(array &$row): void
    {
        $format = 'Y.m.d H:i:s';
        $row = array_filter(
            [
                'login' => $row["Login"],
                'position' => $row["Position"],
                'utm' => $row["UTM"],
                'opened_at' => Carbon::createFromFormat($format, $row["Opened"])->toDateTimeString(),
                'updated_at' => isset($row["Last updated"]) ? Carbon::createFromFormat($format, $row["Last updated"])->toDateTimeString() : null,
                'action' => $row["Action"],
                'symbol' => $row["Symbol"],
                'lead_volume' => $row["Volume"],
                'price' => $this->convert($row["Price"], $row['Currency']),
                'reason' => $row["Reason"],
                'float_result' => $this->convert($row["Floating PL"], $row['Currency']),
                'currency' => $row["Currency"],
            ],
            fn($value) => $value || is_numeric($value)
        );
    }
}