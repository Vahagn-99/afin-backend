<?php

namespace App\Services\Syncer\Mapper;

class CustomFieldFromWebhookMapper implements MapperInterface
{
    use HasCustomFieldsExacter;


    public function handle(array $data): array
    {
        if (!isset($data['custom_fields'])) return [];
        $fields = $data['custom_fields'];

        return $this->extract($fields);
    }
}