<?php

namespace Database\Factories;

use App\Enums\ImportStatusType;
use App\Models\ImportStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ImportStatus>
 */
class ImportStatusFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'status' => ImportStatusType::STATUS_PENDING,
        ];
    }
}
