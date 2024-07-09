<?php

namespace App\Http\Resources\Api\V1\Position;

use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Position $resource
 */
class OpenedPositionCollectionResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'login' => $this->resource->login,
            'utm' => $this->resource->utm,
            'opened_at' => $this->resource->opened_at,
            'updated_at' => $this->resource->updated_at,
            'action' => $this->resource->action,
            'symbol' => $this->resource->symbol,
            'lead_volume' => $this->resource->lead_volume,
            'price' => $this->resource->price,
            'reason' => $this->resource->reason,
            'float_result' => $this->resource->float_result,
            'currency' => $this->resource->currency,
            'position' => $this->resource->position,
            'contact_id' => $this->resource->contact_id,
        ];
    }
}
