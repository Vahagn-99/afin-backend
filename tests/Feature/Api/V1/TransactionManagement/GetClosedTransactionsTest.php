<?php

namespace Tests\Feature\Api\V1\TransactionManagement;

use App\Models\ClosedTransaction;
use App\Models\History;
use Carbon\Carbon;
use Carbon\Translator;
use Tests\TestCase;
use Tests\Traits\HasAuthUser;

class GetClosedTransactionsTest extends TestCase
{
    use HasAuthUser;

    public function test_user_can_get_closed_transactions(): void
    {
        // fake
        $date = '2024-07';
        $date = Carbon::parse($date);
        $history = History::factory()->create([
            'from' => $date->startOfMonth()->toDateString(),
            'to' => $date->endOfMonth()->toDateString(),
            'closet_at' => now()->format("Y-m"),
        ]);
        $closedTransactions = ClosedTransaction::factory()->count(5)->create([
            'history_id' => $history->id,
        ]);

        //request
        $response = $this->json('get', "/api/v1/transactions/histories/$history->id");

        //assertion
        $response->assertStatus(200);
        foreach ($closedTransactions as $transaction) {
            $response->assertJsonFragment([
                'login' => $transaction->login
            ]);
        }
    }
}
