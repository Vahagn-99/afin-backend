<?php

namespace App\Imports\Sheets;

use App\DTO\RateDTO;
use App\Enums\Currency;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use function Psy\debug;

readonly class ClosedPositionsSheet implements ToArray, SkipsEmptyRows, WithHeadingRow
{
    public function array(array $array): void
    {
        $mappedRows = [];
        foreach ($array as $row) {
            $this->mapData($row);
            $mappedRows[] = $row;
        }
        DB::table('positions')->upsert($mappedRows, ['login', 'position']);
    }

    private function mapData(array &$row): void
    {
        try {
            $row = array_filter([
                'login' => $row["Login"],
                'position' => $row["Position"],
                'utm' => $row["UTM"],
                'opened_at' => excel_date_to_human_date($row["Opened"]),
                'closed_at' => excel_date_to_human_date($row["Closed"]),
                'action' => $row["Action"],
                'symbol' => $row["Symbol"],
                'lead_volume' => $row["Volume"],
                'price' => $row["Price"],
                'profit' => $row["Profit"],
                'reason' => $row["Reason"],
                'currency' => $row["Currency"],
            ]);
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }
}