<?php

namespace Tests\Feature\Api\V1\History;

use App\Models\Transaction;
use Tests\TestCase;
use Tests\Traits\HasAuthUser;

class CloseTransactionsMonthTest extends TestCase
{
    use HasAuthUser;

    public function test_user_can_close_transactions_month(): void
    {
        $date = now()->subMonths(2);

        // fake
        $transactions = Transaction::factory()->count(10)->create([
            'created_at' => $date->format("Y-m-d"),
        ]);

        //request
        $response = $this->json('post', '/api/v1/transactions/close', [
            'month' => $date->format("Y-m"),
        ]);

        //assertion
        $response->assertStatus(201);
        $this->assertDatabaseEmpty('transactions');

        $this->assertDatabaseHas('histories', [
            'from' => $date->startOfMonth()->format("Y-m-d"),
            'to' => $date->endOfMonth()->format("Y-m-d"),
            'closet_at' => $date->format("Y-m")
        ]);

        foreach ($transactions as $transaction) {
            $this->assertDatabaseHas('closed_transactions', [
                'id' => $transaction->id,
            ]);
        }
    }
}
