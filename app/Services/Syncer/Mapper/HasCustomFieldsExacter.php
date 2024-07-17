<?php

namespace App\Services\Syncer\Mapper;

trait HasCustomFieldsExacter
{
    private function extract(array $fields): array
    {
        return collect($fields)
            ->pluck('values', "field_id")
            ->map(fn($values) => current($values)['value'])
            ->toArray();
    }
}