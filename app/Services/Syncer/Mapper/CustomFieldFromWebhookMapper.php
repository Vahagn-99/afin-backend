<?php

namespace App\Services\Syncer\Mapper;

class CustomFieldFromWebhookMapper implements MapperInterface
{
    public function handle(array $data): array
    {
        if (!isset($data['custom_fields'])) return [];
        $fields = $data['custom_fields'];
        return $this->extract($fields);
    }

    private function extract(array $fields): array
    {
        return collect($fields)
            ->pluck('values', "id")
            ->map(fn($values) => current($values)['value'])
            ->toArray();
    }
}