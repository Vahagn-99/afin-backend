<?php

namespace Tests\Feature\Api\V1\TransactionManagement;

use App\Models\ArchivedTransaction;
use App\Models\Archive;
use Carbon\Carbon;
use Carbon\Translator;
use Tests\TestCase;
use Tests\Traits\HasAuthUser;

class GetArchivedTransactionsTest extends TestCase
{
    use HasAuthUser;

    public function test_user_can_get_archived_transactions(): void
    {
        // fake
        $date = '2024-07-01';
        $date = Carbon::parse($date);
        $history = Archive::factory()->create([
            'from' => $date->startOfMonth()->toDateString(),
            'to' => $date->endOfMonth()->toDateString(),
            'closet_at' => now()->format("Y-m-d"),
        ]);
        $archivedTransactions = ArchivedTransaction::factory()->count(5)->create([
            'archive_id' => $history->id,
        ]);

        //request
        $response = $this->json('get', "/api/v1/archives/$history->id/transactions");

        //assertion
        $response->assertStatus(200);
        foreach ($archivedTransactions as $transaction) {
            $response->assertJsonFragment([
                'login' => $transaction->login
            ]);
        }
    }
}
