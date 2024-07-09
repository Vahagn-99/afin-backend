<?php

namespace Tests\Feature\Api\V1\History;

use App\Models\History;
use Tests\TestCase;
use Tests\Traits\HasAuthUser;

class GetTransactionsHistoryListTest extends TestCase
{
    use HasAuthUser;

    public function test_user_can_get_transactions_history_list(): void
    {
        // fake
        $histories = History::factory(5)->create();

        //request
        $response = $this->json('get', "/api/v1/transactions/histories");

        //assertion
        $response->assertStatus(200);

        foreach ($histories as $history) {
            $response->assertJsonFragment([
                'id' => $history->id,
                'from' => $history->from,
                'to' => $history->to,
                'path' => $history->path,
                'created_at' => $history->created_at,
            ]);
        }
    }
}
