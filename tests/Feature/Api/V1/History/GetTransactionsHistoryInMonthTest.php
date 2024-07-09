<?php

namespace Tests\Feature\Api\V1\History;

use App\Models\History;
use App\Modules\JsonManager\Json;
use Carbon\Carbon;
use Carbon\Translator;
use Tests\TestCase;
use Tests\Traits\HasAuthUser;

class GetTransactionsHistoryInMonthTest extends TestCase
{
    use HasAuthUser;

    public function test_user_can_get_transactions_history_in_month(): void
    {
        // fake
        $date = '2024-07';
        $date = Carbon::parse($date);
        $monthName = $date->setLocalTranslator(Translator::get('ru'))->monthName;
        $path = $date->year . '_' . $monthName . '_transactions.json';
        $history = History::factory()->create([
            'from' => $date->startOfMonth()->toDateString(),
            'to' => $date->endOfMonth()->toDateString(),
            'path' => $path
        ]);

        //request
        $response = $this->json('get', "/api/v1/transactions/histories/$history->id");

        //assertion
        $response->assertStatus(200);
        $data = Json::get($path)->toArray();
        foreach ($data as $transaction) {
            $response->assertJsonFragment($transaction);
        }
    }
}
