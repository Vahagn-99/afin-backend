<?php

namespace App\Http\Resources\Bonus;

use App\DTO\CalculatedManagerBonusDTO;
use App\Models\ManagerBonus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property ManagerBonus $resource
 */
class ManagerBonusResourceFromModel extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'manager_name' => $this->resource->manager->name,
            'manager_id' => $this->resource->manager_id,
            'contact_id' => $this->resource->contact_id,
            'deposit' => (float)$this->resource->deposit,
            'volume_lots' => (float)$this->resource->volume_lots,
            'bonus' => (float)$this->resource->bonus,
            'potential_bonus' => (float)$this->resource->potential_bonus,
            'payoff' => (float)$this->resource->payoff,
            'paid' => (float)$this->resource->paid,
            'date' => $this->resource->date,
        ];
    }
}
