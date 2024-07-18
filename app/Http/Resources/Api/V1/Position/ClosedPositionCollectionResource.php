<?php

namespace App\Http\Resources\Api\V1\Position;

use App\Http\Resources\Api\V1\Contact\ContactResource;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Position $resource
 */
class ClosedPositionCollectionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'login' => $this->resource->login,
            'utm' => $this->resource->utm,
            'opened_at' => $this->resource->opened_at,
            'closed_at' => $this->resource->closed_at,
            'action' => $this->resource->action,
            'symbol' => $this->resource->symbol,
            'lead_volume' => $this->resource->lead_volume,
            'price' => $this->resource->price,
            'profit' => $this->resource->profit,
            'reason' => $this->resource->reason,
            'currency' => $this->resource->currency,
            'position' => $this->resource->position,
            'contact' => ContactResource::make($this->whenLoaded('contact')),
        ];
    }
}
