<?php

namespace App\Console\Commands;

use App\Models\WebhookClient;
use App\Modules\AmoCRM\Api\Webhook\SubscriberInterface;
use App\Services\Syncer\Config\Config;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

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
        $name = $this->ask('The name of client');
        do {
            $this->warn('Note: the id should be uniq...');
            $id = $this->ask('The id of the client.');
        } while (WebhookClient::query()->where('id', $id)->exists());

        $client = new WebhookClient;
        $client->name = $name;
        $client->id = $id;
        $client->api_key = Str::random(32);
        $client->save();

        $this->info("Webhook token created: $client->api_key");

        $this->syncAmoCRM();
    }

    private function syncAmoCRM(): void
    {
        $webhookClient = WebhookClient::recreate();
        $this->webhookApi->subscribe(
            route('amocrm.webhook.contact') . "?client_id=$webhookClient->id&api_key=$webhookClient->api_key",
            [Config::CONTACT_ADDED_WEBHOOK, Config::CONTACT_UPDATED_WEBHOOK]
        );
    }
}
