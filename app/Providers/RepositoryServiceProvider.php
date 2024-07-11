<?php

namespace App\Providers;

use App\Repositories\Contact\ContactRepository;
use App\Repositories\Contact\ContactRepositoryInterface;
use App\Repositories\Core\TransactionRepositoryInterface;
use App\Repositories\History\TransactionHistoryRepository;
use App\Repositories\History\TransactionHistoryRepositoryInterface;
use App\Repositories\ImportStatus\ImportStatusRepository;
use App\Repositories\ImportStatus\ImportStatusRepositoryInterface;
use App\Repositories\Position\PositionRepository;
use App\Repositories\Position\PositionRepositoryInterface;
use App\Repositories\Transaction\ClosedTransactionRepository;
use App\Repositories\Transaction\ClosedTransactionRepositoryInterface;
use App\Repositories\Transaction\DatabaseTransactionRepositoryInterface;
use App\Repositories\Transaction\TransactionRepository;
use App\Repositories\Transaction\EloquentTransactionRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(DatabaseTransactionRepositoryInterface::class, EloquentTransactionRepository::class);
        $this->app->bind(TransactionRepositoryInterface::class, TransactionRepository::class);
        $this->app->bind(ClosedTransactionRepositoryInterface::class, ClosedTransactionRepository::class);
        $this->app->bind(TransactionHistoryRepositoryInterface::class, TransactionHistoryRepository::class);
        $this->app->bind(PositionRepositoryInterface::class, PositionRepository::class);
        $this->app->bind(ImportStatusRepositoryInterface::class, ImportStatusRepository::class);
        $this->app->bind(ContactRepositoryInterface::class, ContactRepository::class);
    }
}

