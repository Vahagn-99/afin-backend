<?php

namespace Database\Factories;

use App\Models\Manager;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Manager>
 */
class ManagerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id' => $this->faker->numberBetween(99, 99999),
            'name' => $this->faker->name,
            'type' => $this->faker->name,
            'branch' => $this->faker->company,
            'avatar' => $this->faker->filePath()
        ];
    }
}
