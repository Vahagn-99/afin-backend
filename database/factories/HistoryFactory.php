<?php

namespace Database\Factories;

use App\Models\History;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends Factory<History>
 */
class HistoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'from' => $this->faker->date(),
            'to' => $this->faker->date(),
            'closet_at' => now()->toDateTimeString(),
            'created_at' => now()->toDateTimeString(),
        ];
    }
}
