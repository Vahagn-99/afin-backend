<?php

namespace App\Services\Syncer\WebhookHandler;

use App\DTO\SaveContactDTO;
use App\Services\Syncer\Api\UserApi;
use App\Services\Syncer\Config\Config;
use Exception;
use Illuminate\Support\Arr;

readonly class ContactWebhookHandler implements ContactWebhookHandlerInterface
{
    public function __construct(
        private UserApi $userApi,
    )
    {
    }

    /**
     * @throws Exception
     */
    public function handle(array $data): SaveContactDTO
    {
        $contact = current(current(current($data)));
        $customFields = $this->handleCustomField($contact);
        $user = $this->userApi->get($contact['responsible_user_id']);
        return new SaveContactDTO(
            id: $contact['id'],
            name: $contact['name'],
            login: $customFields[Config::LOGIN_FIELD_ID],
            analytic: Arr::get($customFields, Config::ANALYTIC_FIELD_ID),
            manager: $user['name'],
            branch: current($user['groups'])['name'] ?? Config::DEFAULT_BRANCH_NAME
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
                ->whereIn('field_id', [Config::LOGIN_FIELD_ID, Config::ANALYTIC_FIELD_ID])
                ->pluck('values', "field_id")
                ->map(fn($values) => current($values)['value'])
                ->toArray();

        if (!in_array(Config::ANALYTIC_FIELD_ID, array_keys($result))) throw new Exception("Missing login field");

        return $result;
    }
}