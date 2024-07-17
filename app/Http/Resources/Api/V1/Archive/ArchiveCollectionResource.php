<?php

namespace App\Http\Resources\Api\V1\Archive;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ArchiveCollectionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'from' => $this->resource->from,
            'to' => $this->resource->to,
            'name' => $this->resource->name,
            'closet_at' => $this->resource->closet_at,
            'created_at' => $this->resource->created_at,
        ];
    }
}
