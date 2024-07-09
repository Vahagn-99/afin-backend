<?php

namespace Tests\Feature\Api\V1\Transaction;

use App\Models\Transaction;
use Tests\TestCase;
use Tests\Traits\HasAuthUser;

class TransactionsTest extends TestCase
{
    use HasAuthUser;

    public function test_user_can_get_transactions_paginated(): void
    {
        // fake
        Transaction::factory()->count(100)->create();
        //request
        $response = $this->json('get', '/api/v1/transactions?per_page=30&page=1');
        //assertion
        $response->assertStatus(200);
        $response->assertJsonCount(30, 'data');
        $response->assertJsonStructure(['data' =>
                [
                    '*' => [
                        'login',
                        'lk',
                        'currency',
                        'deposit',
                        'withdrawal',
                        'volume_lots',
                        'equity',
                        'balance_start',
                        'balance_end',
                        'commission'
                    ]
                ]
            ]
        );
    }

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

    public function test_user_can_get_transactions_sorted(): void
    {
        // Use factory to create 3 transactions with specified IDs
        foreach (range(1, 3) as $i) {
            Transaction::factory()->create([
                'id' => $i,
            ]);
        }

        // Send a GET request to your API endpoint with sorting parameters
        $response = $this->json('get', '/api/v1/transactions', ['sorts' => [
            'id' => 'desc'
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
