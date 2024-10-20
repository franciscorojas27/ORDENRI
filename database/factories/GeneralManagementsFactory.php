<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GeneralManagements>
 */
class GeneralManagementsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'general_management' => $this->faker->unique()->randomElement([
                'F/MOVILNET',
                'F/Caveguias',
                'F/CANTV.NET',
                'Mercados Masivos',
                'Operadores de Telecomunicaciones',
                'Planificación y Finazas',
                'Asuntos Regulatorios',
                'Centro de Servicios',
                'Empresas e Instituciones',
                'Tecnología y Operaciones',

            ])
        ];
    }
}
