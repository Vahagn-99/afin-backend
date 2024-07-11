<?php

namespace App\Http\Resources\Api\V1\Contact;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Contact $resource
 */
class ContactResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'client' => $this->resource->client,
            'manager' => $this->resource->manager,
            'group' => $this->resource->group,
            'branch' => $this->resource->branch,
            'analytic' => $this->resource->analytic
        ];
    }
}
