<?php

namespace App\Repositories\ImportStatus;

interface ImportStatusRepositoryInterface
{
    public function getCurrent(): array;

    public function getById($id): array;
}