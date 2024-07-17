<?php

namespace App\Http\Resources\Api\V1\Contact;

use App\Http\Resources\Api\V1\Manager\ManagerResource;
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
            'login' => $this->resource->login,
            'url' => $this->resource->url,
            'name' => $this->resource->name,
            'manager_id' => $this->resource->manager_id,
            'analytic' => $this->resource->analytic,
            'manager' => ManagerResource::make($this->whenLoaded('manager'))
        ];
    }
}
