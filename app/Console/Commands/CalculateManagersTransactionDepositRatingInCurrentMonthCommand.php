<?php

namespace App\Console\Commands;

use App\DTO\SaveManagerRatingDTO;
use App\Modules\FilterManager\Filter\FiltersAggregor;
use App\Modules\FilterManager\Filter\MakeFilterDTO;
use App\Repositories\Contact\ContactRepositoryInterface;
use App\Repositories\ManagerRating\ManagerRatingRepositoryInterface;
use App\Repositories\Transaction\TransactionDepositCalculateInterface;
use App\Services\Syncer\Config\Config;
use Illuminate\Console\Command;

class CalculateManagersTransactionDepositRatingInCurrentMonthCommand extends Command
{
    protected $signature = 'managers-ratings-deposit';
    protected $description = 'The command to calculate managers transaction deposit';

    public function __construct(
        private readonly TransactionDepositCalculateInterface $transactionRepository,
        private readonly ManagerRatingRepositoryInterface     $ratingRepository,
        private readonly ContactRepositoryInterface           $contactRepository
    )
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $totals = $this->calculateTotalAndGroupByLogin();
        $managerIds = $this->getManagersIdByLogin(array_keys($totals));
        foreach ($totals as $login => $total) {
            $managerId = $managerIds[$login] ?? false;
            if (!$managerId) {
                $this->error('Manager ' . $login . ' not found');
                continue;
            }
            $this->ratingRepository->save(new SaveManagerRatingDTO(
                managerId: $managerId,
                type: Config::RATING_TYPE_DEPOSIT_TOTAL,
                total: $total,
                date: now()->startOfMonth()->format("Y-m-d")
            ));
            $this->info('The manager ID:' . $managerId . ' was successfully synchronized.');
        }
    }

    private function calculateTotalAndGroupByLogin(): array
    {
        return $this->transactionRepository->calculate();
    }

    private function getManagersIdByLogin(array $logins)
    {
        $filter = new FiltersAggregor();
        $filter->addFilter(new MakeFilterDTO('logins', $logins));
        return collect(
            $this->contactRepository
                ->getOnly(['manager_id', 'login'], $filter)
        )
            ->keyBy('login')
            ->map(fn($item) => $item['manager_id'])
            ->toArray();
    }
}
