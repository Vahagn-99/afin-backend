<?php

if (!function_exists('excel_date_to_human_date')) {
    function excel_date_to_human_date($excelDate, $format = 'Y-m-d H:i:s'): string
    {
        // The Unix epoch (January 1, 1970) is 25569 days after the Excel epoch (January 1, 1900)
        $unixEpoch = ($excelDate - 25569) * 86400; // Convert days to seconds
        return date($format, $unixEpoch);
    }
}