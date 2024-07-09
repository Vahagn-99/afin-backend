<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Contact>
 */
class ContactFactory extends Factory
{

    public function definition(): array
    {
        return [
            'client' => $this->faker->name(),
            'manager' => $this->faker->name(),
            'group' => $this->faker->company(),
            'branch' => $this->faker->name(),
        ];
    }
}
