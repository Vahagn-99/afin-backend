<?php

namespace App\Http\Controllers\Api\V1\Import;

use App\Http\Controllers\Controller;
use App\Repositories\ImportStatus\ImportStatusRepositoryInterface;
use Illuminate\Http\JsonResponse;

class StatusController extends Controller
{
    public function __construct(private readonly ImportStatusRepositoryInterface $importRepository)
    {
    }

    public function __invoke(): JsonResponse
    {
        $status = $this->importRepository->getCurrent();
        return response()->json([
            'status' => $status['status']
        ]);
    }
}
