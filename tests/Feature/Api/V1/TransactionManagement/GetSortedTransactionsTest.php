<?php

namespace Tests\Feature\Api\V1\TransactionManagement;

use App\Models\Transaction;
use Tests\TestCase;
use Tests\Traits\HasAuthUser;

class GetSortedTransactionsTest extends TestCase
{
    use HasAuthUser;

    public function test_user_can_get_transactions_sorted(): void
    {
        // Use factory to create 3 transactions with specified IDs
        foreach (range(1, 3) as $i) {
            Transaction::factory()->create([
                'login' => $i,
            ]);
        }

        // Send a GET request to your API endpoint with sorting parameters
        $response = $this->json('get', '/api/v1/transactions', ['sorts' => [
            'login' => 'desc'
        ]]);

        // Assert the response status is 200
        $response->assertStatus(200);

        // Assert that there are 3 items in the 'data' array
        $response->assertJsonCount(3, 'data');

        // Assert the order of the items in the 'data' array
        $response->assertJsonPath('data.0.login', 3);
        $response->assertJsonPath('data.1.login', 2);
        $response->assertJsonPath('data.2.login', 1);
    }
}
