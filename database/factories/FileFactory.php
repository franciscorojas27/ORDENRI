<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\File>
 */
class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => $this->faker->numberBetween(1, 20),
            'file_path' => $this->faker->filePath(),
            'file_name' => $this->faker->word(),
            'mime_type' => $this->faker->mimeType(),
            'size' => $this->faker->numberBetween(100, 5000), // size in bytes
            'original_name' => $this->faker->word() . '.txt',

        ];
    }
}
