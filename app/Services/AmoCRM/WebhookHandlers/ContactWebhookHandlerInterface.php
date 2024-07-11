<?php

namespace App\Services\AmoCRM\WebhookHandlers;

use App\DTO\SaveContactDTO;
use Exception;

interface ContactWebhookHandlerInterface
{
    /**
     * @throws Exception
     */
    public function handle(array $data): SaveContactDTO;
}