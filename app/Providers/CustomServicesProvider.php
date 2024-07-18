<?php

namespace App\Providers;

use App\Services\BonusCalculator\ManagerCalculatedBonusRepository;
use App\Services\BonusCalculator\ManagerCalculatedBonusRepositoryInterface;
use App\Services\CloseTransaction\CloseMonthService;
use App\Services\CloseTransaction\CloseMonthServiceInterface;
use App\Services\Convertor\ConverterInterface;
use App\Services\Convertor\AmountConverter;
use Illuminate\Support\ServiceProvider;

class CustomServicesProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CloseMonthServiceInterface::class, CloseMonthService::class);
        $this->app->bind(ConverterInterface::class, AmountConverter::class);
        $this->app->bind('currency_converter', ConverterInterface::class);
    }
}
