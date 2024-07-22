<?php

namespace App\Services\BonusCalculator;

use App\DTO\CalculatedManagerBonusDTO;
use App\Models\Manager;
use App\Modules\FilterManager\Filter\FiltersAggregor;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
                'manager_bonuses.contact_id',
            ])
            ->whereYear('manager_bonuses.date', '=', $prevMonth->year)
            ->whereMonth('manager_bonuses.date', '=', $prevMonth->month);

        return Manager::query()
            ->select([
                DB::raw('managers.name as manager_name'),
                DB::raw('managers.branch as manager_branch'),
                DB::raw('c.id as contact_id'),
                DB::raw('c.name as contact_name'),
                DB::raw('c.url as contact_url'),
                DB::raw('managers.id as manager_id'),
                DB::raw('sum(t.deposit) as deposit'),
                DB::raw('sum(t.volume_lots) as volume_lots'),
                DB::raw('sum(t.deposit * 0.02 - t.volume_lots * 100) as potential_bonus'),
                DB::raw('sum(t.deposit * 0.02) as bonus'),
                DB::raw('sum(t.volume_lots * 100) as payoff'),
                DB::raw('sum(b.payoff) as paid'),
            ])
            ->join(DB::raw('contacts as c'), 'c.manager_id', '=', 'managers.id')
            ->join(DB::raw('transactions as t'), 't.login', '=', 'c.login')
            ->leftJoinSub($prevMonthBonusesSubQuery, 'b', 'b.contact_id', '=', 'c.id')
            ->groupBy([
                'managers.name',
                'managers.branch',
                'managers.id',
                'c.id',
                'c.name',
                'c.url',
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
                date: $date->format('Y-m-d')
            ))
            ->groupBy('manager_name')
            ->toArray();
    }
}