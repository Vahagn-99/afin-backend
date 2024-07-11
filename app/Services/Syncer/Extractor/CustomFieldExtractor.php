<?php

namespace App\Services\Syncer\Extractor;

use App\Services\Syncer\Config\Config;
use Exception;

class CustomFieldExtractor
{
    public static function handle(array $contact):array
    {
        if (!isset($contact['custom_fields'])) throw new Exception("Missing custom fields");

        $result =
            collect($contact['custom_fields'])
                ->whereIn('field_id', [Config::LOGIN_FIELD_ID, Config::ANALYTIC_FIELD_ID])
                ->pluck('values', "field_id")
                ->map(fn($values) => current($values)['value'])
                ->toArray();

        if (!in_array(Config::ANALYTIC_FIELD_ID, array_keys($result))) throw new Exception("Missing login field");

        return $result;
    }
}