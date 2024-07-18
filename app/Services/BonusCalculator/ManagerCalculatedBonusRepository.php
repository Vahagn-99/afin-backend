<?php

namespace App\Services\BonusCalculator;

use App\DTO\CalculatedManagerBonusDTO;
use App\Models\Manager;
use App\Modules\FilterManager\Filter\FiltersAggregor;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use stdClass;

class ManagerCalculatedBonusRepository implements ManagerCalculatedBonusRepositoryInterface
{
    public function calculatedByDate(string $date, ?FiltersAggregor $filters = null): array
    {
        $date = Carbon::create($date);
        $prevMonth = $date->copy()->subMonth();

        $prevMonthBonusesSubQuery = DB::table('manager_bonuses')
            ->select([
                'manager_bonuses.id',
                'manager_bonuses.payoff',
                'manager_bonuses.manager_id',
            ])
            ->whereYear('manager_bonuses.date', '=', $prevMonth->year)
            ->whereMonth('manager_bonuses.date', '=', $prevMonth->month);

        return Manager::query()
            ->select([
                DB::raw('managers.name as manager_name'),
                DB::raw('managers.branch as manager_branch'),
                DB::raw('c.id as contact_id'),
                DB::raw('managers.id as manager_id'),
                DB::raw('t.deposit as deposit'),
                DB::raw('t.volume_lots as volume_lots'),
                DB::raw('(t.deposit * 0.02) as bonus'),
                DB::raw('(t.deposit * 0.02 - t.volume_lots * 100) as potential_bonus'),
                DB::raw('(t.deposit * 0.02) as bonus'),
                DB::raw('(t.volume_lots * 100) as payoff'),
                DB::raw('b.payoff as paid'),
            ])
            ->join(DB::raw('contacts as c'), 'c.manager_id', '=', 'managers.id')
            ->join(DB::raw('transactions as t'), 't.login', '=', 'c.login')
            ->leftJoinSub($prevMonthBonusesSubQuery, 'b', 'b.manager_id', '=', 'managers.id')
            ->groupBy([
                'managers.name',
                'managers.branch',
                'c.id',
                'managers.id',
                't.deposit',
                't.volume_lots',
                'b.payoff'
            ])
            ->filter($filters)
            ->get()
            ->map(fn($item) => new CalculatedManagerBonusDTO(
                manager_name: $item->manager_name,
                manager_branch: $item->manager_branch,
                manager_id: $item->manager_id,
                contact_id: $item->contact_id,
                deposit: $item->deposit,
                volume_lots: $item->volume_lots,
                bonus: $item->bonus,
                potential_bonus: $item->potential_bonus,
                payoff: $item->payoff,
                paid: $item->paid ?? 0,
                date: $date->format('Y-m-d')
            ))
            ->groupBy('manager_name')
            ->toArray();
    }
}