<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        return [
            'name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->lexify('???????') . '@gmail.com',
            'userid' => Str::lower(fake()->unique()->lexify('???????')),
            'phone' => fake()->phoneNumber(),
            'ip_address' => fake()->ipv4(),
            'group' => fake()->boolean(),
            'can_create_orders' => fake()->boolean(),
            'resolution_area_id' => fake()->numberBetween(1, 4),
            'coordination_management' => fake()->unique()->company(),
            'password_may_expire_at' => fake()->dateTimeBetween('-1 years', '+1 years'),
            'last_connection' => fake()->dateTimeBetween('-1 years', '+1 years'),
            'job_title_id' => fake()->numberBetween(1, 3),
            'general_management_id' => fake()->numberBetween(1, 10),
            'email_verified_at' => fake()->dateTimeBetween('-1 years', '+1 years'),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
