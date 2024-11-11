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
        $statuses = [
            'Pendiente',
            'En Proceso',
            'Finalizada',
            'Evaluación',
            'Rechazada',
            'Anulada',
        ];

        // Crea un array para almacenar los estados generados
        $createdStatuses = [];

        foreach ($statuses as $status) {
            $createdStatuses[] = Status::create(['status' => $status]);
        }

        return $createdStatuses;
    }
}
