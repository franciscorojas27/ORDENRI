<?php

namespace Database\Factories;

use Carbon\Carbon;
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
        return [
            'resolution_area_id' => $this->faker->numberBetween(1, 4),
            'type_id' => $this->faker->numberBetween(1, 3),
            'client_description' => $this->faker->text(400),
            'description' => $this->faker->randomElement([null, $this->faker->text(400)]),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'start_at' => $this->faker->dateTimeBetween('now', '+1 month'),
            'end_at' => $this->faker->dateTimeBetween('+1 month', '+2 months'),
            'status_id' => $this->faker->numberBetween(1, 3),
            'client_id' => $this->getRandomClientId($this->faker->numberBetween(1, 4)),
            'applicant_to_id' => $this->getRandomApplicantId($this->faker->numberBetween(1, 4)),
            'responsible_id' => $this->getRandomResponsibleId($this->faker->numberBetween(1, 4)),
        ];
    }

    public function orderStatusPending()
    {
        return $this->state(fn($attributes) => [
            // Fecha de creación dentro del último año
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'status_id' => 1, // Estatus pendiente
            'client_id' => $this->getRandomClientId($attributes['resolution_area_id']),
        ]);
    }

    public function orderStatusStarted()
    {
        // Generar una fecha de creación para la orden
        $createdAt = $this->faker->dateTimeBetween('-1 year', 'now');
        // Generar una fecha de inicio posterior a la fecha de creación
        $startAt = $this->faker->dateTimeBetween($createdAt, 'now');

        return $this->state(fn($attributes) => [
            'status_id' => 2, // Estatus iniciado
            'created_at' => $createdAt,
            'start_at' => $startAt,
            'client_id' => $this->getRandomClientId($attributes['resolution_area_id']),
            'applicant_to_id' => $this->getRandomApplicantId($attributes['resolution_area_id']),
        ]);
    }

    public function orderStatusEnd()
    {
        return $this->state(function ($attributes) {
            $createdAt = $this->faker->dateTimeBetween('2024-12-01 00:00:00', '2024-12-28 23:59:59');

            $startAt = clone $createdAt;
            $startAt->modify('+5 hours');

            $hours = $this->faker->numberBetween(16, 18);
            $endAt = clone $startAt;
            $endAt->modify("+$hours hours");

            if ($endAt <= $startAt) {
                $endAt->modify('+1 hour');
            }
            return [
                'status_id' => $this->faker->numberBetween(1,3),
                'created_at' => $createdAt,
                'start_at' => $startAt,
                'end_at' => $endAt,
                'client_id' => $this->getRandomClientId($attributes['resolution_area_id']),
                'applicant_to_id' => $this->getRandomApplicantId($attributes['resolution_area_id']),
                'responsible_id' => $this->getRandomResponsibleId($attributes['resolution_area_id']),
            ];
        });
    }


    /**
     * Get a random client ID based on the resolution area.
     */
    private function getRandomClientId(int $resolutionAreaId): int
    {
        $users = [
            1 => User::where('resolution_area_id', 1)->pluck('id')->toArray(),
            2 => User::where('resolution_area_id', 2)->pluck('id')->toArray(),
            3 => User::where('resolution_area_id', 3)->pluck('id')->toArray(),
            4 => User::where('resolution_area_id', 4)->pluck('id')->toArray(),
        ];

        return $users[$resolutionAreaId][array_rand($users[$resolutionAreaId])];
    }

    /**
     * Get a random applicant ID based on the resolution area.
     */
    private function getRandomApplicantId(int $resolutionAreaId): int
    {
        return $this->getRandomClientId($resolutionAreaId);
    }

    /**
     * Get a random responsible ID based on the resolution area.
     */
    private function getRandomResponsibleId(int $resolutionAreaId): int
    {
        return $this->getRandomClientId($resolutionAreaId);
    }
}
