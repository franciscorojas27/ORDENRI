<?php

namespace Database\Factories;
use App\Models\JobTitle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobTitle>
 */
class JobTitleFactory extends Factory
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
    public static function createOrderedJobTitles(): array
    {
        return array_map(fn($title) => JobTitle::create(['title' => $title]), [
            'Cliente',
            'Analista',
            'Supervisor',
            'Administrador'
        ]);
    }
}
