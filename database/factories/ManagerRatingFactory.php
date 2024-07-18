<?php

namespace Database\Factories;

use App\Models\Manager;
use App\Models\ManagerRating;
use App\Services\Syncer\Config\Config;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ManagerRating>
 */
class ManagerRatingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'total' => $this->faker->randomFloat(),
            'manager_id' => $this->faker->randomDigitNotZero(),
            'date' => $this->faker->date('Y-m-d'),
            'type' => array_rand([Config::RATING_TYPE_DEPOSIT_TOTAL, Config::RATING_TYPE_DEPOSIT_TOTAL]),
        ];
    }
}
