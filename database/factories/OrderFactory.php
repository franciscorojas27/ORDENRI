<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    { 
        $a = User::find(1);
        return [
            'client_id' => 1,
            'applicant_to_id' => 1,
            'responsible_id' => 1,
            'resolution_area_id' => $this->faker->numberBetween(1, 4),
            'type_id' => $this->faker->numberBetween(1, 3),
            'status_id' => $this->faker->numberBetween(1, 7),
            'client_description' => $this->faker->text(400),
            'description' => $this->faker->text(400),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'evaluation_at' => $this->faker->optional()->dateTimeBetween('-1 year', 'now'),
            'start_at' => $this->faker->optional()->dateTimeBetween('-1 year', 'now'),
            'end_at' => $this->faker->optional()->dateTimeBetween('-1 year', 'now'),
            'closed_at' => $this->faker->optional()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
