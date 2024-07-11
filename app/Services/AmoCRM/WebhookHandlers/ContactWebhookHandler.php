<?php

namespace App\Services\AmoCRM\WebhookHandlers;

use App\DTO\SaveContactDTO;
use App\Services\AmoCRM\Api\GetContactsByLogin;
use Exception;
use Illuminate\Support\Arr;

class ContactWebhookHandler implements ContactWebhookHandlerInterface
{
    /**
     * @throws Exception
     */
    public function handle(array $data): SaveContactDTO
    {
        $contact = current(current(current($data)));
        $customFields = $this->handleCustomField($contact);
        return new SaveContactDTO(
            id: $contact['id'],
            name: $contact['name'],
            login: $customFields[GetContactsByLogin::LOGIN_FIELD_ID],
            analytic: Arr::get($customFields, GetContactsByLogin::ANALYTIC_FIELD_ID),
        );
    }

    /**
     * @throws Exception
     */
    private function handleCustomField(array $contact)
    {
        if (!isset($contact['custom_fields'])) throw new Exception("Missing custom fields");

        $result =
            collect($contact['custom_fields'])
                ->whereIn('field_id', [GetContactsByLogin::LOGIN_FIELD_ID, GetContactsByLogin::ANALYTIC_FIELD_ID])
                ->pluck('values', "field_id")
                ->map(fn($values) => current($values)['value'])
                ->toArray();

        if (!in_array(GetContactsByLogin::ANALYTIC_FIELD_ID, array_keys($result))) throw new Exception("Missing login field");

        return $result;
    }
}