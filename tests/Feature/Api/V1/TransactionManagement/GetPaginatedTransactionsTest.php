<?php

namespace Tests\Feature\Api\V1\TransactionManagement;

use App\Models\Transaction;
use Tests\TestCase;
use Tests\Traits\HasAuthUser;

class GetPaginatedTransactionsTest extends TestCase
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
}
