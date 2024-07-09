<?php

namespace Tests\Feature\Api\V1\Import;

use App\Jobs\Transaction\SyncTransactionsWithAmoCRMContacts;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Tests\Traits\HasAuthUser;

class ImportDataTest extends TestCase
{
    use HasAuthUser;

    public function test_user_can_import_data_from_xlsx_file(): void
    {
        //fake
        Queue::fake([SyncTransactionsWithAmoCRMContacts::class]);
        $path = Storage::path('test_import.xlsx');
        $file = new UploadedFile($path, 'test_import.xlsx', 'xlsx', null, true);

        //request
        $response = $this->json('post', '/api/v1/import', [
            'file' => $file,
            'currencies' => [
                'usd' => 70,
                'eur' => 60,
                'cny' => 120
            ]
        ]);

        // assertions
        $response->assertStatus(201);
        $this->assertDatabaseCount('transactions', 49);
        $this->assertDatabaseCount('positions', 49 * 2);
        Queue::assertPushed(SyncTransactionsWithAmoCRMContacts::class);
    }
}
