<?php

namespace App\Http\Controllers\AmoCRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\AmoCRM\Oauth\CallbackRequest;
use App\Models\WebhookClient;
use App\Modules\AmoCRM\Api\Webhook\SubscriberInterface;
use App\Modules\AmoCRM\Core\Facades\Amo;
use App\Services\Syncer\Config\Config;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{

    public function __construct(
        private readonly SubscriberInterface $webhookApi
    )
    {
    }

    public function auth(): RedirectResponse
    {
        return redirect(Amo::authenticator()->url());
    }

    public function callback(CallbackRequest $request): RedirectResponse
    {
        Amo::authenticator()->exchangeCodeWithAccessToken($request->validated('code'));
        $webhookClient = WebhookClient::recreate();
        $this->webhookApi->subscribe(
            route('amocrm.webhook.contact') . "?client_id=$webhookClient->id&api_key=$webhookClient->api_key",
            [Config::CONTACT_ADDED_WEBHOOK, Config::CONTACT_UPDATED_WEBHOOK]
        );
        return redirect()->back();
    }
}