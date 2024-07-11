<?php

namespace App\Imports\Sheets;

use Exception;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

readonly class ClosedPositionSheetImport implements ToArray, SkipsEmptyRows, WithHeadingRow
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