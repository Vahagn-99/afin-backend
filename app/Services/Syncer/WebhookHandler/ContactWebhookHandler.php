<?php

namespace App\Services\Syncer\WebhookHandler;

use App\DTO\SaveContactDTO;
use App\Services\Syncer\Api\UserApi;
use App\Services\Syncer\Config\Config;
use App\Services\Syncer\Extractor\CustomFieldExtractor;
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
        $customFields = CustomFieldExtractor::handle($contact);
        $user = $this->userApi->getOne($contact['responsible_user_id']);
        return new SaveContactDTO(
            id: $contact['id'],
            name: $contact['name'],
            login: $customFields[Config::LOGIN_FIELD_ID],
            analytic: Arr::get($customFields, Config::ANALYTIC_FIELD_ID),
            manager: $user['name'],
            branch: current($user['groups'])['name'] ?? Config::DEFAULT_BRANCH_NAME
        );
    }
}