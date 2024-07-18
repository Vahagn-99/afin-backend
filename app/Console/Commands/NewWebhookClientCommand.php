<?php

namespace App\Console\Commands;

use App\Models\WebhookClient;
use App\Modules\AmoCRM\Api\Webhook\SubscriberInterface;
use App\Services\Syncer\Config\Config;
use Illuminate\Console\Command;

class NewWebhookClientCommand extends Command
{
    protected $signature = 'amo:reload-webhook';

    protected $description = 'The command to create a webhook token';

    public function __construct(private readonly SubscriberInterface $webhookApi)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $webhookClient = WebhookClient::recreate();
        $this->info("Webhook token created: $webhookClient->api_key");
        $this->syncAmoCRM($webhookClient);
        $this->info("Webhook synced to account : $webhookClient->name");
    }

    private function syncAmoCRM(WebhookClient $webhookClient): void
    {
        $url = route('amocrm.webhook.contact') . "?client_id=$webhookClient->id&api_key=$webhookClient->api_key";
        $actions = [Config::CONTACT_ADDED_WEBHOOK, Config::CONTACT_UPDATED_WEBHOOK];

        $this->webhookApi->subscribe($url, $actions);
    }
}
