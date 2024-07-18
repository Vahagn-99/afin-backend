<?php

namespace App\Services\Syncer\Mapper;

class CustomFieldFromApiMapper implements MapperInterface
{
    use HasCustomFieldsExacter;

    public function handle(array $data): array
    {
        if (!isset($data['custom_fields_values'])) return [];
        $fields = $data['custom_fields_values'];
        return $this->extract($fields);
    }
}