<?php

namespace Database\Factories;

use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Type>
 */
class TypeFactory extends Factory
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
     * Crea los títulos de trabajo en orden específico.
     *
     * @return array
     */
    public static function createOrderedTypes(): array
    {
        return array_map(fn($title) => Type::create(['type' => $title]), [
            'Requerimiento',
            'Soporte',
            'Falla',
        ]);
    }
}
