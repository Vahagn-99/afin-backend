<?php

namespace Database\Factories;

use App\Models\Contact;
use App\Models\Manager;
use App\Models\ManagerBonus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ManagerBonus>
 */
class ManagerBonusFactory extends Factory
{
    public function definition(): array
    {
        return [
            'contact_id' => Contact::factory()->create()->getKey(),
            'manager_id' => Manager::factory()->create()->getKey(),
            'deposit' => round($this->faker->randomFloat(2, 9.99, 999999.99), 2),
            'volume_lots' => round($this->faker->randomFloat(2, 9.99, 999999.99), 2),
            'bonus' => round($this->faker->randomFloat(2, 9.99, 999999.99), 2),
            'potential_bonus' => round($this->faker->randomFloat(2, 9.99, 999999.99), 2),
            'payoff' => round($this->faker->randomFloat(2, 9.99, 999999.99), 2),
            'paid' => round($this->faker->randomFloat(2, 9.99, 999999.99), 2),
            'date' => $this->faker->date(),
        ];
    }
}
