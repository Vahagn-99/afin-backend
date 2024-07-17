<?php

namespace App\Console\Commands\Rating;

use App\Models\WebhookClient;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class NewWebhookClientCommand extends Command
{
    protected $signature = 'webhook:client';

    protected $description = 'The command to create a webhook token';

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
    }
}
