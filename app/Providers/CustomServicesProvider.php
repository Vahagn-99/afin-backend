<?php

namespace App\Providers;

use App\Services\CloseTransaction\CloseTransactionService;
use App\Services\CloseTransaction\CloseTransactionServiceInterface;
use App\Services\Deposit\ConverterInterface;
use App\Services\Deposit\DepositConverter;
use Illuminate\Support\ServiceProvider;

class CustomServicesProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CloseTransactionServiceInterface::class, CloseTransactionService::class);
        $this->app->bind(ConverterInterface::class, DepositConverter::class);
        $this->app->bind('currency_converter', ConverterInterface::class);

    }
}
