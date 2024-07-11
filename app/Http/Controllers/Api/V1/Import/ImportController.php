<?php

namespace App\Http\Controllers\Api\V1\Import;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Import\ImportRequest;
use App\Imports\ImportManager;
use App\Jobs\Transaction\SyncTransactionsWithAmoCRMContacts;
use Illuminate\Http\JsonResponse;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function __construct()
    {
    }

    public function __invoke(ImportRequest $request): JsonResponse
    {
        Excel::queueImport(
            new ImportManager($request->currencyDTO()),
            $request->validated('file'),
        )->chain([
            new SyncTransactionsWithAmoCRMContacts(),
        ])->onQueue('import');

        return response()->json([
            'message' => 'File imported successfully'
        ], 201);
    }
}
