<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Resolution_Area>
 */
class Resolution_AreaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'area' => $this->faker->unique()->randomElement([
                'Desarrollo',
                'Provision',
                'SSNVL',
                'Administración'
            ])
        ];
    }
}
