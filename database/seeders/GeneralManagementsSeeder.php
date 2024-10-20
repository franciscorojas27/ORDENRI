<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GeneralManagements;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GeneralManagementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GeneralManagements::factory(10)->create();
    }
}
