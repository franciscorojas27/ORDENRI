<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            JobTitleSeeder::class,
            StatusSeeder::class,
            TypeSeeder::class,
            GeneralManagementsSeeder::class,
            ResolutionAreaSeeder::class,
            UserSeeder::class,
            OrderSeeder::class,
            // Agrega otros seeders aquí según sea necesario
        ]);
    
    }
}
