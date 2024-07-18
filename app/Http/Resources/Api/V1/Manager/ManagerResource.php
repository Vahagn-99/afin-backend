<?php

namespace App\Http\Resources\Api\V1\Manager;

use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Manager $resource
 */
class ManagerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'branch' => $this->resource->branch,
            'avatar' => $this->resource->avatar,
            'type' => $this->resource->type,
        ];
    }
}
