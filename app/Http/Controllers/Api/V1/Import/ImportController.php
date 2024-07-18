<?php

namespace App\Http\Controllers\Api\V1\Import;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Import\ImportRequest;
use App\Imports\ImportPipeline;
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
            new ImportPipeline($request->currencyDTO()),
            $request->validated('file'),
        )->onQueue('import');

        return response()->json([
            'message' => 'processing! please wait...',
        ], 201);
    }
}
