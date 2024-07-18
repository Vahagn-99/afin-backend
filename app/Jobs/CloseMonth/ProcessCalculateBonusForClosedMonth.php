<?php

namespace App\Jobs\CloseMonth;

use App\DTO\CalculatedManagerBonusDTO;
use App\DTO\CloseMonthDTO;
use App\Repositories\ManagerBonus\ManagerBonusRepositoryInterface;
use App\Services\BonusCalculator\ManagerCalculatedBonusRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessCalculateBonusForClosedMonth implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly CloseMonthDTO $closeMonthDTO)
    {
        $this->onQueue('calculating.bonus');
        $this->afterCommit();
    }

    public function handle(
        ManagerCalculatedBonusRepositoryInterface $calculatedBonusRepository,
        ManagerBonusRepositoryInterface           $bonusRepository): void
    {
        $date = Carbon::create($this->closeMonthDTO->closedAt);
        /**@var array<CalculatedManagerBonusDTO> $bonuses */
        $bonuses = $calculatedBonusRepository->calculatedByDate($date->format('Y-m-d'));
        foreach ($bonuses as $managerBonuses) {
            foreach ($managerBonuses as $bonus) {
                $bonusRepository->save($bonus);
            }
        }
    }
}
