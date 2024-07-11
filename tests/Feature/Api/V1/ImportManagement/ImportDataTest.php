<?php

namespace Tests\Feature\Api\V1\ImportManagement;

use App\Jobs\Transaction\SyncTransactionsWithAmoCRMContacts;
use App\Models\Contact;
use Carbon\Carbon;
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
        $this->assertDatabaseCount('transactions', 10);
        $this->assertDatabaseCount('positions', 10 * 2);

        foreach ($this->expectedOpenedPositions() as $position) {
            $this->assertDatabaseHas('positions', $position);
        }
        foreach ($this->expectedClosedPositions() as $position) {
            $this->assertDatabaseHas('positions', $position);
        }
        foreach ($this->expectedTransactions() as $transaction) {
            $this->assertDatabaseHas('transactions', $transaction);
        }

        Queue::assertPushed(SyncTransactionsWithAmoCRMContacts::class);
    }

    public function expectedOpenedPositions(): array
    {
        return [
            [
                "position" => 1035609404,
                "login" => 1000001166,
                "opened_at" => "2024-04-25 16:26:27",
                "updated_at" => "2024-04-30 23:59:59",
                "action" => "buy",
                "symbol" => "USDMXNrfd",
                "lead_volume" => 0.08,
                "price" => 17.34558,
                "reason" => "Mobile",
                "float_result" => -9193.43,
                "currency" => "RUB",
            ],
            [
                "position" => 1035611015,
                "login" => 1000001166,
                "opened_at" => "2024-04-25 16:49:40",
                "updated_at" => "2024-04-30 23:59:59",
                "action" => "buy",
                "symbol" => "USDMXNrfd",
                "lead_volume" => 0.15,
                "price" => 17.29815,
                "reason" => "Mobile",
                "float_result" => -13370.76,
                "currency" => "RUB",
            ],
            [
                "position" => 1035706502,
                "login" => 1000001166,
                "opened_at" => "2024-04-29 15:55:49",
                "updated_at" => "2024-04-30 23:59:59",
                "action" => "buy",
                "symbol" => "USDRUBrfd",
                "lead_volume" => 0.1,
                "price" => 93.22,
                "reason" => "Mobile",
                "float_result" => -2413,
                "currency" => "RUB",
            ],
            [
                "position" => 1035757998,
                "login" => 1000001166,
                "opened_at" => "2024-04-30 18:48:25",
                "updated_at" => "2024-04-30 23:59:59",
                "action" => "sell",
                "symbol" => "EURSEKrfd",
                "lead_volume" => 0.03,
                "price" => 11.74358,
                "reason" => "Mobile",
                "float_result" => -473.26,
                "currency" => "RUB",
            ],
            [
                "position" => 1035759600,
                "login" => 1000001166,
                "opened_at" => "2024-04-30 19:27:03",
                "updated_at" => "2024-04-30 23:59:59",
                "action" => "buy",
                "symbol" => "USDMXNrfd",
                "lead_volume" => 0.09,
                "price" => 17.10784,
                "reason" => "Mobile",
                "float_result" => 1287.02,
                "currency" => "RUB",
            ],
            [
                "position" => 1035696076,
                "login" => 1000002058,
                "opened_at" => "2024-04-29 10:56:25",
                "updated_at" => "2024-04-30 23:59:59",
                "action" => "sell",
                "symbol" => "USDJPYrfd",
                "lead_volume" => 1.4,
                "price" => 156.1305,
                "reason" => "Mobile",
                "float_result" => -139268.62,
                "currency" => "RUB",
            ],
            [
                "position" => 1035749535,
                "login" => 1000002852,
                "opened_at" => "2024-04-30 16:24:45",
                "updated_at" => "2024-04-30 23:59:59",
                "action" => "buy",
                "symbol" => "USDMXNrfd",
                "lead_volume" => 0.01,
                "price" => 17.04574,
                "reason" => "Mobile",
                "float_result" => 480.53,
                "currency" => "RUB",
            ],
            [
                "position" => 1035749520,
                "login" => 1000002862,
                "opened_at" => "2024-04-30 16:24:34",
                "updated_at" => "2024-04-30 23:59:59",
                "action" => "buy",
                "symbol" => "USDMXNrfd",
                "lead_volume" => 0.1,
                "price" => 17.04626,
                "reason" => "Mobile",
                "float_result" => 4777.06,
                "currency" => "RUB",
            ],
            [
                "position" => 1035749530,
                "login" => 1000002862,
                "opened_at" => "2024-04-30 16:24:40",
                "updated_at" => "2024-04-30 23:59:59",
                "action" => "buy",
                "symbol" => "USDMXNrfd",
                "lead_volume" => 0.01,
                "price" => 17.04658,
                "reason" => "Mobile",
                "float_result" => 475.97,
                "currency" => "RUB",
            ],
            [
                "position" => 1034608313,
                "login" => 1000004638,
                "opened_at" => "2024-03-21 16:27:30",
                "updated_at" => "2024-04-30 23:59:59",
                "action" => "buy",
                "symbol" => "GBPUSDrfd",
                "lead_volume" => 0.01,
                "price" => 1.27168,
                "reason" => "Mobile",
                "float_result" => -22.59,
                "currency" => "USD",
            ]
        ];


    }

    public function expectedTransactions(): array
    {
        return [
            [
                "login" => 1000001166,
                "lk" => 200195,
                "currency" => "RUB",
                "deposit" => 40000.0,
                "withdrawal" => 0,
                "volume_lots" => 38.23,
                "equity" => 184179.99,
                "balance_start" => 233989.53,
                "balance_end" => 208343.42,
                "commission" => -65646.11,
            ],
            [
                "login" => 1000001351,
                "lk" => 201080,
                "currency" => "RUB",
                "deposit" => 0.0,
                "withdrawal" => 0,
                "volume_lots" => 0,
                "equity" => 0,
                "balance_start" => 0,
                "balance_end" => 0,
                "commission" => 0,
            ],
            [
                "login" => 1000002058,
                "lk" => 211461,
                "currency" => "RUB",
                "deposit" => 201000.0,
                "withdrawal" => 0,
                "volume_lots" => 162.74,
                "equity" => 544251.32,
                "balance_start" => 637328.38,
                "balance_end" => 683519.94,
                "commission" => -154808.44,
            ],
            [
                "login" => 1000002852,
                "lk" => 212990,
                "currency" => "RUB",
                "deposit" => 0.0,
                "withdrawal" => 0,
                "volume_lots" => 4.57,
                "equity" => 5815.69,
                "balance_start" => 7680.65,
                "balance_end" => 5335.16,
                "commission" => -2345.49,
            ],
            [
                "login" => 1000002858,
                "lk" => 212966,
                "currency" => "RUB",
                "deposit" => 0.0,
                "withdrawal" => 0,
                "volume_lots" => 0,
                "equity" => 3.54,
                "balance_start" => 3.54,
                "balance_end" => 3.54,
                "commission" => 0,
            ],
            [
                "login" => 1000002862,
                "lk" => 212990,
                "currency" => "RUB",
                "deposit" => 58000.0,
                "withdrawal" => 0,
                "volume_lots" => 37.79,
                "equity" => 57539.31,
                "balance_start" => 17683.36,
                "balance_end" => 52286.28,
                "commission" => -23397.08,
            ],
            [
                "login" => 1000003081,
                "lk" => 201080,
                "currency" => "USD",
                "deposit" => 0.0,
                "withdrawal" => 0,
                "volume_lots" => 0,
                "equity" => 0.41,
                "balance_start" => 0.41,
                "balance_end" => 0.41,
                "commission" => 0,
            ],
            [
                "login" => 1000003524,
                "lk" => 213441,
                "currency" => "RUB",
                "deposit" => 0.0,
                "withdrawal" => 0,
                "volume_lots" => 0,
                "equity" => 20.59,
                "balance_start" => 20.59,
                "balance_end" => 20.59,
                "commission" => 0,
            ],
            [
                "login" => 1000003525,
                "lk" => 213441,
                "currency" => "RUB",
                "deposit" => 0.0,
                "withdrawal" => 0,
                "volume_lots" => 0,
                "equity" => 0,
                "balance_start" => 0,
                "balance_end" => 0,
                "commission" => 0,
            ],
            [
                "login" => 1000003915,
                "lk" => 212966,
                "currency" => "RUB",
                "deposit" => 0.0,
                "withdrawal" => 0,
                "volume_lots" => 0,
                "equity" => 0,
                "balance_start" => 0,
                "balance_end" => 0,
                "commission" => 0,
            ]
        ];
    }

    private function expectedClosedPositions(): array
    {
        return [
            [
                "login" => "1000014947",
                "position" => "1023976239",
                "utm" => "24a",
                "opened_at" => "2023-04-06 16:37:05",
                "closed_at" => "2024-04-29 04:30:36",
                "action" => "sell",
                "symbol" => "AUDJPYrfd",
                "lead_volume" => "0.01",
                "price" => 87.609,
                "profit" => "-102.64",
                "reason" => "Client",
                "currency" => "USD",
            ],
            ["login" => "1000014947",
                "position" => "1024898782",
                "utm" => "24a",
                "opened_at" => "2023-05-04 17:22:13",
                "closed_at" => "2024-04-16 08:09:03",
                "action" => "sell",
                "symbol" => "AUDJPYrfd",
                "lead_volume" => "0.01",
                "price" => 89.279,
                "profit" => "-64.26",
                "reason" => "Client",
                "currency" => "USD",
            ],
            ["login" => "1000014947",
                "position" => "1025896957",
                "utm" => "24a",
                "opened_at" => "2023-06-05 14:40:35",
                "closed_at" => "2024-04-04 13:07:33",
                "action" => "sell",
                "symbol" => "AUDJPYrfd",
                "lead_volume" => "0.01",
                "price" => 92.369,
                "profit" => "-51.84",
                "reason" => "Client",
                "currency" => "USD",
            ],
            ["login" => "1100001208",
                "position" => "1027013265",
                "utm" => "24a",
                "opened_at" => "2024-04-01 18:35:40",
                "closed_at" => "2024-04-03 18:21:09",
                "action" => "buy",
                "symbol" => "EURUSDrfd",
                "lead_volume" => "0.03",
                "price" => 1.0735,
                "profit" => "27.00",
                "reason" => "Mobile",
                "currency" => "USD",
            ],
            ["login" => "1000013516",
                "position" => "1029558904",
                "utm" => "24",
                "opened_at" => "2023-10-09 10:14:30",
                "closed_at" => "2024-04-10 17:06:16",
                "action" => "buy",
                "symbol" => "USDCHFrfd",
                "lead_volume" => "0.10",
                "price" => 0.91208,
                "profit" => "0.99",
                "reason" => "Client",
                "currency" => "USD",
            ],
            ["login" => "1000009427",
                "position" => "1030263057",
                "utm" => "24b",
                "opened_at" => "2023-11-03 15:30:11",
                "closed_at" => "2024-04-12 10:30:38",
                "action" => "sell",
                "symbol" => "EURUSDrfd",
                "lead_volume" => "0.05",
                "price" => 1.068,
                "profit" => "1.75",
                "reason" => "Mobile",
                "currency" => "USD",
            ],
            ["login" => "1000013516",
                "position" => "1030312411",
                "utm" => "24",
                "opened_at" => "2023-11-01 11:17:30",
                "closed_at" => "2024-04-19 05:19:34",
                "action" => "buy",
                "symbol" => "USDMXNrfd",
                "lead_volume" => "0.10",
                "price" => 18.04587,
                "profit" => "37.67",
                "reason" => "Client",
                "currency" => "USD",
            ],
            ["login" => "1000014066",
                "position" => "1030355622",
                "utm" => "24",
                "opened_at" => "2023-11-02 05:53:59",
                "closed_at" => "2024-04-17 09:24:55",
                "action" => "sell",
                "symbol" => "EURUSDrfd",
                "lead_volume" => "0.05",
                "price" => 1.05945,
                "profit" => "-12.65",
                "reason" => "Client",
                "currency" => "USD",
            ],
            ["login" => "1000014066",
                "position" => "1030360492",
                "utm" => "24",
                "opened_at" => "2023-11-02 09:48:51",
                "closed_at" => "2024-04-10 20:20:57",
                "action" => "sell",
                "symbol" => "EURUSDrfd",
                "lead_volume" => "0.05",
                "price" => 1.0595,
                "profit" => "-74.50",
                "reason" => "Client",
                "currency" => "USD",
            ],
            ["login" => "1000014066",
                "position" => "1030360768",
                "utm" => "24",
                "opened_at" => "2023-11-02 09:58:36",
                "closed_at" => "2024-04-16 05:53:47",
                "action" => "sell",
                "symbol" => "EURUSDrfd",
                "lead_volume" => "0.05",
                "price" => 1.05996,
                "profit" => "-5.10",
                "reason" => "Client",
                "currency" => "USD",
            ]
        ];
    }
}