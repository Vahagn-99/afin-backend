<?php

namespace App\Jobs\CloseMonth;

use App\DTO\CloseMonthDTO;
use App\DTO\SaveManagerRatingDTO;
use App\Modules\FilterManager\Filter\FiltersAggregor;
use App\Modules\FilterManager\Filter\MakeFilterDTO;
use App\Repositories\Archive\ArchiveRepositoryInterface;
use App\Repositories\ArchivedTransaction\ArchivedTransactionDepositCalculateInterface;
use App\Repositories\Contact\ContactRepositoryInterface;
use App\Repositories\ManagerRating\ManagerRatingRepositoryInterface;
use App\Services\Syncer\Config\Config;
use Carbon\Carbon;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessCalculateRatingForClosedMonth implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    private ArchivedTransactionDepositCalculateInterface $transactionRepository;
    private ManagerRatingRepositoryInterface $ratingRepository;
    private ContactRepositoryInterface $contactRepository;
    private ArchiveRepositoryInterface $archiveRepository;

    public function __construct(
        private readonly CloseMonthDTO $closeMonthDTO,
    )
    {
        $this->onQueue('calculating.rating');
        $this->afterCommit();

        $this->transactionRepository = app(ArchivedTransactionDepositCalculateInterface::class);
        $this->ratingRepository = app(ManagerRatingRepositoryInterface::class);
        $this->contactRepository = app(ContactRepositoryInterface::class);
        $this->archiveRepository = app(ArchiveRepositoryInterface::class);
    }

    public function handle(): void
    {
        $date = Carbon::create($this->closeMonthDTO->closedAt);
        $archiveId = $this->archiveRepository->getArchiveIdByDate($date->format("Y-m-d"));
        $totals = $this->calculateTotalAndGroupByLogin($archiveId);
        $managerIds = $this->getManagersIdByLogin(array_keys($totals));
        foreach ($totals as $login => $total) {
            $managerId = $managerIds[$login] ?? false;
            if (!$managerId) continue;
            $this->ratingRepository->save(new SaveManagerRatingDTO(
                managerId: $managerId,
                type: Config::RATING_TYPE_DEPOSIT_TOTAL,
                total: $total,
                date: $date->startOfMonth()->format("Y-m-d")
            ));
        }
    }

    private function calculateTotalAndGroupByLogin(int $id): array
    {
        $filter = new FiltersAggregor();
        $filter->addFilter(new MakeFilterDTO('archive_id', $id));
        return $this->transactionRepository->calculate($filter);
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
