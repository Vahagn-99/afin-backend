<?php

namespace Tests\Feature\Api\V1\History;

use App\Models\Transaction;
use Carbon\Carbon;
use Carbon\Translator;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Tests\Traits\HasAuthUser;

class CloseTransactionsMonthTest extends TestCase
{
    use HasAuthUser;

    public function test_user_can_close_transactions_month(): void
    {
        $date = now()->subMonths(2);

        // fake
        Transaction::factory()->count(10)->create([
            'created_at' => $date->format("Y-m-d"),
        ]);

        //request
        $response = $this->json('post', '/api/v1/transactions/close', [
            'month' => $date->format("Y-m"),
        ]);

        //assertion
        $response->assertStatus(201);
        $this->assertDatabaseEmpty('transactions');

        $monthName = Carbon::create($date)->setLocalTranslator(Translator::get('ru'))->monthName;
        $path = $date->year . '_' . $monthName . '_transactions.json';

        $this->assertFileExists(Storage::disk('testing')->path($path), 'file was exported to the history cloud');

        $this->assertDatabaseHas('histories', [
            'from' => $date->startOfMonth()->format("Y-m-d"),
            'to' => $date->endOfMonth()->format("Y-m-d"),
            'path' => $path
        ]);
    }
}
