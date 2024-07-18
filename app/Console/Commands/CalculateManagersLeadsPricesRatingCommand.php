<?php

namespace App\Console\Commands;

use AmoCRM\Filters\BaseRangeFilter;
use AmoCRM\Filters\LeadsFilter;
use App\DTO\SaveManagerRatingDTO;
use App\Modules\AmoCRM\Api\Lead\LeadApiInterface;
use App\Repositories\ManagerRating\ManagerRatingRepositoryInterface;
use App\Services\Syncer\Config\Config;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CalculateManagersLeadsPricesRatingCommand extends Command
{
    protected $signature = 'managers-ratings-leads';
    protected $description = 'The command to synchronize amo managers';

    public function __construct(
        private readonly LeadApiInterface                 $leadApi,
        private readonly ManagerRatingRepositoryInterface $repo,

    )
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $date = Carbon::now()->startOfMonth();
        $leads = $this->getGivenMonthLeads($date);
        $groupedBy = $this->calculateBudgetAndGroupByManagerId($leads);
        foreach ($groupedBy as $managerId => $total) {
            $this->repo->save(new SaveManagerRatingDTO(
                managerId: $managerId,
                type: Config::RATING_TYPE_LEADS_TOTAL,
                total: $total,
                date: $date->format("Y-m-d")
            ));
            $this->info('The manager ID:' . $managerId . ' was successfully synchronized.');
        }
    }

    private function getGivenMonthLeads(Carbon $date): array
    {
        $filter = new LeadsFilter();
        $range = new BaseRangeFilter();
        $range->setFrom($date->startOfMonth()->unix());
        $range->setTo($date->endOfMonth()->unix());
        $filter->setCreatedAt($range);
        $filter->setPipelineIds(Config::RATING_PIPELINE_ID);
        $filter->setStatuses(Config::RATING_STATUSES_ID);
        return $this->leadApi->get($filter);
    }

    private function calculateBudgetAndGroupByManagerId(array $leads): array
    {
        return collect($leads)
            ->groupBy('responsible_user_id')
            ->map(fn($leads) => $leads->sum('price'))
            ->toArray();
    }
}
