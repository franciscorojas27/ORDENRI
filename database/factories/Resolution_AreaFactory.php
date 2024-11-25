<?php

namespace Database\Factories;
use App\Models\Resolution_Area;

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

        return [];
    }
    public static function createOrderedResolution_Areas(): array
    {
        return array_map(fn($area) => Resolution_Area::create(['area' => $area]), [
            'Desarrollo',
            'Provision',
            'SSNVL',
            'Administración'
        ]);
    }
}
