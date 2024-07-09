<?php

namespace App\Modules\JsonManager;

use Illuminate\Support\Collection;

interface ColletionableTransactionManagerInterface extends JsonTransactionManagerInterface
{
    public function toCollection(): Collection;
}