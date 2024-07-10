<?php

namespace Tests\Feature\Api\V1\Import;

use App\Enums\ImportStatusType;
use App\Models\ImportStatus;
use Tests\TestCase;
use Tests\Traits\HasAuthUser;

class ImportStatusTest extends TestCase
{
    use HasAuthUser;

    public function test_user_can_get_current_importing_status(): void
    {
        //fake
        ImportStatus::factory()->create([
            'status' => ImportStatusType::STATUS_PENDING
        ]);

        //request
        $response = $this->json('get', '/api/v1/import/status');

        // assertions
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'status' => 'pending'
        ]);
    }
}
