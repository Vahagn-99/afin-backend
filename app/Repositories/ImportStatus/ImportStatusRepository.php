<?php

namespace App\Repositories\ImportStatus;

use App\Models\ImportStatus;

class ImportStatusRepository implements ImportStatusRepositoryInterface
{
    public function getCurrent(): array
    {
        return ImportStatus::query()->orderByDesc('created_at')->first()->toArray();
    }

    public function getById($id): array
    {
        return ImportStatus::query()->find($id)->toArray();
    }
}