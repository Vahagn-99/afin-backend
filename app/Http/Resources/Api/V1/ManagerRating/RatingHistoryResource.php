<?php

namespace App\Http\Resources\Api\V1\ManagerRating;

use App\Models\Contact;
use App\Models\Manager;
use App\Models\ManagerRating;
use Carbon\Carbon;
use Carbon\Translator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RatingHistoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $date = Carbon::createFromFormat("Y-m", $this->resource->date);
        $name = "Рейтинг за " . $date->setLocalTranslator(Translator::get('ru'))->monthName . ' ' . $date->year;

        return [
            'name' => $name,
            'date' => $this->resource->date,
        ];
    }
}
