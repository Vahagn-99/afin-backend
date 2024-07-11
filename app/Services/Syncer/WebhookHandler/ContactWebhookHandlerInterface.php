<?php

namespace App\Services\Syncer\WebhookHandler;

use App\DTO\SaveContactDTO;
use Exception;

interface ContactWebhookHandlerInterface
{
    /**
     * @throws Exception
     */
    public function handle(array $data): SaveContactDTO;
}