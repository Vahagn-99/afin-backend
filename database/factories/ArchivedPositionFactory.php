<?php

namespace Database\Factories;

use App\Models\ArchivedPosition;
use App\Models\Archive;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ArchivedPosition>
 */
class ArchivedPositionFactory extends Factory
{

    public function definition(): array
    {
        return [
            'login' => (int)uniqid(),
            'utm' => array_rand(['24', '24a']),
            'opened_at' => now()->toDateTimeString(),
            'updated_at' => now()->toDateTimeString(),
            'closed_at' => now()->toDateTimeString(),
            'action' => array_rand(['sell', 'buy']),
            'symbol' => array_rand(['AUDJPYrfd', 'GBPAUDrfd', 'AUDUSDrfd', 'EURUSDrfd']),
            'lead_volume' => $this->faker->randomFloat(2, 1, 100),
            'price' => $this->faker->randomFloat(2, 1, 100),
            'profit' => $this->faker->randomFloat(2, 1, 100),
            'reason' => array_rand(['Mobile', 'Client']),
            'float_result' => $this->faker->randomFloat(2, 1, 100),
            'currency' => strtoupper(array_rand(['rub', 'usd', 'syn'])),
            'position' => $this->faker->numberBetween(99999, 1000000),
            'archive_id' => Archive::factory()->create()->getKey(),
        ];
    }
}
