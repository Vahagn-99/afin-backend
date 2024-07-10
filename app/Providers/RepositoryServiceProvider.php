<?php

namespace App\Providers;

use App\Repositories\Core\DatabasePaginatedTransactionRepository;
use App\Repositories\History\TransactionHistoryPaginatedRepositoryInterface;
use App\Repositories\History\TransactionHistoryRepository;
use App\Repositories\History\TransactionHistoryRepositoryInterface;
use App\Repositories\ImportStatus\ImportStatusRepository;
use App\Repositories\ImportStatus\ImportStatusRepositoryInterface;
use App\Repositories\Position\PositionPaginatedRepositoryInterface;
use App\Repositories\Position\PositionRepository;
use App\Repositories\Position\PositionRepositoryInterface;
use App\Repositories\Transaction\DatabaseTransactionRepositoryInterface;
use App\Repositories\Transaction\EloquentPaginatedTransactionRepository;
use App\Repositories\Transaction\EloquentTransactionRepository;
use App\Repositories\Transaction\FileSystemTransactionRepositoryInterface;
use App\Repositories\Transaction\JsonTransactionRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(DatabaseTransactionRepositoryInterface::class, EloquentTransactionRepository::class);
        $this->app->bind(DatabasePaginatedTransactionRepository::class, EloquentPaginatedTransactionRepository::class);
        $this->app->bind(FileSystemTransactionRepositoryInterface::class, JsonTransactionRepository::class);
        $this->app->bind(TransactionHistoryRepositoryInterface::class, TransactionHistoryRepository::class);
        $this->app->bind(TransactionHistoryPaginatedRepositoryInterface::class, TransactionHistoryRepository::class);
        $this->app->bind(PositionRepositoryInterface::class, PositionRepository::class);
        $this->app->bind(PositionPaginatedRepositoryInterface::class, PositionRepository::class);
        $this->app->bind(ImportStatusRepositoryInterface::class, ImportStatusRepository::class);

    }
}

