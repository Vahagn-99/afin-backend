<?php

namespace App\Http\Resources\Bonus;

use App\DTO\CalculatedManagerBonusDTO;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property CalculatedManagerBonusDTO $resource
 */
class ManagerBonusResourceFromDTO extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            $this->resource->manager_name => [
                'manager_name' => $this->resource->manager_name,
                'manager_id' => $this->resource->manager_id,
                'contact_id' => $this->resource->contact_id,
                'deposit' => $this->resource->deposit,
                'volume_lots' => $this->resource->volume_lots,
                'bonus' => $this->resource->bonus,
                'potential_bonus' => $this->resource->potential_bonus,
                'payoff' => $this->resource->payoff,
                'paid' => $this->resource->paid
            ]
        ];
    }
}
