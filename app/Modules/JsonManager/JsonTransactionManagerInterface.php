<?php

namespace App\Modules\JsonManager;

interface JsonTransactionManagerInterface
{
    public function get(string $path): static;

    public function all(): array;

    public function save(array $transactions, string $date): string;

    public function name(): string;

    public function path(): string;
}