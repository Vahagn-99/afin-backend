<?php

namespace App\Modules\JsonManager;

interface ArrayableTransactionManagerInterface extends JsonTransactionManagerInterface
{
    public function toArray();
}