<?php

namespace App\Http\Resources\Api\V1\History;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class HistoryCollectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'from' => $this->resource->from,
            'to' => $this->resource->to,
            'path' => $this->resource->path,
            'name' => $this->resource->name,
            'created_at' => $this->resource->created_at,
        ];
    }
}
