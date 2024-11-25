<?php
namespace Database\Factories;

use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

class StatusFactory extends Factory
{
    /**
     * Define el modelo por defecto.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [];
    }

    /**
     * Crea los estados en orden específico.
     *
     * @return array
     */
    public static function createOrderedStatuses(): array
    {
        return array_map(fn($status) => Status::create(['status' => $status]), [
            'Pendiente',
            'En Proceso',
            'Finalizada',
            'Evaluación',
            'Rechazada',
            'Anulada',
        ]);
    }
}
