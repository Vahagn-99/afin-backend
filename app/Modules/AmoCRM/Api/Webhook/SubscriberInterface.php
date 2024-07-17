<?php

namespace App\Modules\AmoCRM\Api\Webhook;

interface SubscriberInterface
{
    public function subscribe(string $destination, array $actions): void;

    public function refresh(string $destination, array $actions): void;
}
