<?php

namespace Tests\Feature\AmoCRM\ManageContactWebhook;

use App\Models\WebhookClient;
use App\Modules\AmoCRM\Api\User\UserApi;
use App\Services\Syncer\Config\Config;
use Mockery;
use Tests\TestCase;

class CanHandleIncomingContactWebhookTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $mockUserApi = Mockery::mock(UserApi::class);
        $mockUserApi->shouldReceive('getOne')->andReturn([
            'id' => 3332,
            'name' => 'John Doe',
            'groups' => [
                [
                    'id' => 1,
                    'name' => 'Group 1',
                ]
            ]
        ]);
        $this->app->instance(UserApi::class, $mockUserApi);
    }

    public function test_can_handle_incoming_contact_webhook_if_passed_client_id_and_api_key(): void
    {
        // fake
        $webhookClient = WebhookClient::recreate();

        // request
        $response = $this->post("/amocrm/webhooks/contacts?client_i=$webhookClient->id&api_key=$webhookClient->api_key", [
            'contacts' => [
                'add' => [
                    [
                        'id' => 454545,
                        'name' => 'test contact',
                        'responsible_user_id' => 3332,
                        'custom_fields' => [
                            [
                                'field_id' => Config::LOGIN_FIELD_ID,
                                'values' => [
                                    [
                                        'value' => '56565656'
                                    ]
                                ],
                            ],
                            [
                                'field_id' => Config::ANALYTIC_FIELD_ID,
                                'values' => [
                                    [
                                        'value' => "Аналитик 4"
                                    ]
                                ],
                            ],
                        ],
                    ]
                ]
            ]
        ]);

        // assertions
        $response->assertOk();
        $this->assertDatabaseHas('contacts', [
            'id' => 454545,
            'name' => 'test contact',
            'manager_id' => 3332,
            'analytic' => "Аналитик 4"
        ]);
    }
}