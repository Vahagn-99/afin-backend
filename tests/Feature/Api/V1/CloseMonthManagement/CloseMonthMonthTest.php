<?php

namespace Tests\Feature\Api\V1\CloseMonthManagement;

use App\Models\Position;
use App\Models\Transaction;
use Tests\TestCase;
use Tests\Traits\HasAuthUser;

class CloseMonthMonthTest extends TestCase
{
    use HasAuthUser;

    public function test_user_can_close_month(): void
    {
        $date = now()->subMonths(2);

        // fake
        $transactions = Transaction::factory()->count(10)->create([
            'created_at' => $date->format("Y-m-d"),
        ]);

        $positions = Position::factory()->count(10)->create();

        //request
        $response = $this->json('post', '/api/v1/close', [
            'month' => $date->format("Y-m"),
        ]);

        //assertion
        $response->assertStatus(201);
        $this->assertDatabaseEmpty('transactions');
        $this->assertDatabaseEmpty('positions');

        $this->assertDatabaseHas('archives', [
            'from' => $date->copy()->startOfMonth()->format("Y-m-d"),
            'to' => $date->copy()->endOfMonth()->format("Y-m-d"),
            'closet_at' => $date->copy()->startOfMonth()->format("Y-m-d")
        ]);

        foreach ($transactions as $transaction) {
            $this->assertDatabaseHas('archived_transactions', [
                'login' => $transaction->login,
            ]);
        }

        foreach ($positions as $position) {
            $this->assertDatabaseHas('archived_positions', [
                'login' => $position->login,
            ]);
        }
    }
}
