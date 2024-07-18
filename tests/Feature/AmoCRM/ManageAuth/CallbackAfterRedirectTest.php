<?php

namespace Tests\Feature\AmoCRM\ManageAuth;

use App\Modules\AmoCRM\Api\Webhook\SubscriberInterface;
use App\Modules\AmoCRM\Core\Facades\Amo;
use Mockery;
use Tests\TestCase;

class CallbackAfterRedirectTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $mockWebhookApi = Mockery::mock(SubscriberInterface::class);
        $mockWebhookApi->shouldReceive('subscribe')
            ->once();

        $this->app->instance(SubscriberInterface::class, $mockWebhookApi);

    }

    public function test_can_handle_access_token_after_in_incoming_callback(): void
    {
        // fake
        Amo::fake();

        // request
        $response = $this->post('/amocrm/auth/callback', [
            'code' => 'test code'
        ]);

        // assertions
        $response->assertRedirectToRoute('app');
        Amo::assertAccessTokenSaved();
    }
}