<?php

namespace App\Http\Resources\Api\V1\ManagerRating;

use App\Models\Contact;
use App\Models\Manager;
use App\Models\ManagerRating;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ManagerWithRatingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'date' => $this->resource->date,
            'type' => $this->resource->type,
            'avatar' => $this->resource->avatar,
            'branch' => $this->resource->branch,
            'leads_total' => (float)$this->resource->leads_total,
            'deposit_total' => (float)$this->resource->deposit_total
        ];
    }
}
