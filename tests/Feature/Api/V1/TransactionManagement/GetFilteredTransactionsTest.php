<?php

namespace Tests\Feature\Api\V1\TransactionManagement;

use App\Models\Transaction;
use Tests\TestCase;
use Tests\Traits\HasAuthUser;

class GetFilteredTransactionsTest extends TestCase
{
    use HasAuthUser;

    public function test_user_can_get_transactions_filtered(): void
    {
        // fake
        Transaction::factory()->count(10)->create();
        Transaction::factory()->count(2)->create(['lk' => 77775]); // filterable
        //request
        $response = $this->json('get', '/api/v1/transactions', ['filters' => [
            'lk' => 77775
        ]]);
        //assertion
        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
    }
}
