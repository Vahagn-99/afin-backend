<?php

namespace Database\Factories;

use App\Models\Archive;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends Factory<Archive>
 */
class ArchiveFactory extends Factory
{
    public function definition(): array
    {
        return [
            'from' => $this->faker->date(),
            'to' => $this->faker->date(),
            'closet_at' => $this->faker->date,
            'created_at' => now()->toDateTimeString(),
        ];
    }
}
