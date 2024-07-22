<?php

namespace App\Repositories\ManagerBonus;

use App\DTO\FindBonusDTO;
use App\DTO\CalculatedManagerBonusDTO;
use App\Models\ManagerBonus;
use App\Modules\FilterManager\Filter\FiltersAggregor;
use App\Repositories\Core\HasRelations;
use App\Repositories\Core\RepositoryFather;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use stdClass;

class ManagerBonusRepository extends RepositoryFather implements ManagerBonusRepositoryInterface
{
    use HasRelations;

    protected function setQuery(): void
    {
        $this->query = ManagerBonus::query();
    }

    public function save(CalculatedManagerBonusDTO $saveManagerBonusDTO): array
    {
        $bonus = $this->getQuery()->updateOrCreate(
            [
                'contact_id' => $saveManagerBonusDTO->contact_id,
                'manager_id' => $saveManagerBonusDTO->manager_id,
                'date' => Carbon::create($saveManagerBonusDTO->date)->startOfMonth()->format('Y-m-d'),
            ],
            [
                'deposit' => $saveManagerBonusDTO->deposit,
                'volume_lots' => $saveManagerBonusDTO->volume_lots,
                'bonus' => $saveManagerBonusDTO->bonus,
                'potential_bonus' => $saveManagerBonusDTO->potential_bonus,
                'payoff' => $saveManagerBonusDTO->payoff,
                'paid' => $saveManagerBonusDTO->paid,
            ]);

        return $bonus->toArray();
    }

    public function getAll(?FiltersAggregor $filters = null): array
    {
        return $this->getQuery()
            ->select([
                DB::raw('m.name as manager_name'),
                DB::raw('m.branch as manager_branch'),
                DB::raw('c.manager_id as manager_id'),
                DB::raw('contact_id'),
                DB::raw('c.name as contact_name'),
                DB::raw('c.url as contact_url'),
                DB::raw('sum(deposit) as deposit'),
                DB::raw('sum(volume_lots) as volume_lots'),
                DB::raw('sum(bonus) as bonus'),
                DB::raw('sum(potential_bonus) as potential_bonus'),
                DB::raw('sum(payoff) as payoff'),
                DB::raw('sum(paid) as paid'),
                DB::raw("date"),
            ])
            ->join(DB::raw('managers as m'), 'manager_bonuses.manager_id', '=', 'm.id')
            ->join(DB::raw('contacts as c'), 'manager_bonuses.contact_id', '=', 'c.id')
            ->groupBy([
                'date',
                'contact_id',
                'contact_name',
                'contact_url',
                'c.manager_id',
                'manager_name',
                'manager_branch',
            ])
            ->filter($filters)
            ->get()
            ->map(fn($item) => new CalculatedManagerBonusDTO(
                manager_name: $item->manager_name,
                manager_branch: $item->manager_branch,
                manager_id: $item->manager_id,
                contact_name: $item->contact_name,
                contact_url: $item->contact_url,
                contact_id: $item->contact_id,
                deposit: round($item->deposit, 2),
                volume_lots: round($item->volume_lots, 2),
                bonus: round($item->bonus, 2),
                potential_bonus: round($item->potential_bonus, 2),
                payoff: round($item->payoff, 2),
                paid: round($item->paid ?? 0, 2),
                date: $item->date
            ))
            ->groupBy('manager_name')
            ->toArray();
    }

    public function getBy(FindBonusDTO $findBonusDTO): ManagerBonus
    {
        $date = Carbon::create($findBonusDTO);
        return $this->getQuery()
            ->where('contact_id', $findBonusDTO->contactId)
            ->where('manager_id', $findBonusDTO->managerId)
            ->whereYear('date', $date->year)
            ->whereMonth('date', $date->month)
            ->first();
    }
}