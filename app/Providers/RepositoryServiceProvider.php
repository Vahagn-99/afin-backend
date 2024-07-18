<?php

namespace App\Providers;

use App\Repositories\Archive\ArchiveRepository;
use App\Repositories\Archive\ArchiveRepositoryInterface;
use App\Repositories\ArchivedTransaction\ArchivedTransactionDepositCalculateInterface;
use App\Repositories\ArchivedTransaction\ArchivedTransactionRepository;
use App\Repositories\ArchivedTransaction\ArchivedTransactionRepositoryInterface;
use App\Repositories\Contact\ContactRepository;
use App\Repositories\Contact\ContactRepositoryInterface;
use App\Repositories\ImportStatus\ImportStatusRepository;
use App\Repositories\ImportStatus\ImportStatusRepositoryInterface;
use App\Repositories\Manager\ManagerRepository;
use App\Repositories\Manager\ManagerRepositoryInterface;
use App\Repositories\ManagerBonus\ManagerBonusRepository;
use App\Repositories\ManagerBonus\ManagerBonusRepositoryInterface;
use App\Repositories\ManagerRating\ManagerRatingHistoryRepository;
use App\Repositories\ManagerRating\ManagerRatingHistoryRepositoryInterface;
use App\Repositories\ManagerRating\ManagerRatingRepository;
use App\Repositories\ManagerRating\ManagerRatingRepositoryInterface;
use App\Repositories\Position\ArchivedPositionRepository;
use App\Repositories\Position\ArchivedPositionRepositoryInterface;
use App\Repositories\Position\PositionRepository;
use App\Repositories\Position\PositionRepositoryInterface;
use App\Repositories\Transaction\TransactionDepositCalculateInterface;
use App\Repositories\Transaction\TransactionRepository;
use App\Repositories\Transaction\TransactionRepositoryInterface;
use App\Services\BonusCalculator\ManagerCalculatedBonusRepositoryInterface;
use App\Services\BonusCalculator\ManagerCalculatedBonusRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TransactionRepositoryInterface::class, TransactionRepository::class);
        $this->app->bind(TransactionDepositCalculateInterface::class, TransactionRepository::class);
        $this->app->bind(ArchivedTransactionDepositCalculateInterface::class, ArchivedTransactionRepository::class);
        $this->app->bind(ArchivedTransactionRepositoryInterface::class, ArchivedTransactionRepository::class);
        $this->app->bind(ArchiveRepositoryInterface::class, ArchiveRepository::class);
        $this->app->bind(PositionRepositoryInterface::class, PositionRepository::class);
        $this->app->bind(ArchivedPositionRepositoryInterface::class, ArchivedPositionRepository::class);
        $this->app->bind(ImportStatusRepositoryInterface::class, ImportStatusRepository::class);
        $this->app->bind(ContactRepositoryInterface::class, ContactRepository::class);
        $this->app->bind(ManagerRepositoryInterface::class, ManagerRepository::class);
        $this->app->bind(ManagerRatingRepositoryInterface::class, ManagerRatingRepository::class);
        $this->app->bind(ManagerRatingHistoryRepositoryInterface::class, ManagerRatingHistoryRepository::class);
        $this->app->bind(ManagerBonusRepositoryInterface::class, ManagerBonusRepository::class);
        $this->app->bind(ManagerCalculatedBonusRepositoryInterface::class, ManagerCalculatedBonusRepository::class);
    }
}

