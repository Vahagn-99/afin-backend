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
        $id = $this->faker->numberBetween(4545, 6786786);
        return [
            'id' => $id,
            'login' => $this->faker->numberBetween(4545, 6786786),
            'name' => $this->faker->name(),
            'manager_id' => $this->faker->numberBetween(4545, 6786786),
            'analytic' => $this->faker->name(),
            'url' => sprintf(config('services.amocrm.contact_url'), $id)
        ];
    }
}
