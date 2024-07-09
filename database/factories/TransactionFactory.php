<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Transaction>
 */
class TransactionFactory extends Factory
{

    public function definition(): array
    {
        return [
            'id' => $this->faker->numberBetween(5000, 9999999),
            'lk' => $this->faker->numberBetween(5000, 9999),
            'currency' => array_rand(['USD', 'EUR', 'GBP']),
            'deposit' => 100000,
            'withdrawal' => 212990,
            'volume_lots' => 5800,
            'equity' => 0,
            'balance_start' => 37.79,
            'balance_end' => 57539.31,
            'commission' => 17683.36,
            'created_at' => $this->faker->dateTimeBetween('-3 months', '+3 months'),
            'contact_id' => null,
        ];
    }
}
