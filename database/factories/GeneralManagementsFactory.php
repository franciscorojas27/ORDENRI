<?php

namespace Database\Factories;
use App\Models\GeneralManagements;
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
        return [];
    }
    /**
     * Crea las gerencias generales en orden específico.
     *
     * @return array
     */
    public static function createOrderedGeneralManagements(): array
    {
        return array_map(fn($general_management) => GeneralManagements::create(['general_management' => $general_management]), [
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

        ]);
    }
}
