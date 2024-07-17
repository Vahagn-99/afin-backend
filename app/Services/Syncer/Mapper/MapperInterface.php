<?php

namespace App\Services\Syncer\Mapper;

interface MapperInterface
{
    public function handle(array $data): array;
}