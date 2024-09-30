<?php

namespace Database\Seeders;

use App\Models\Resolution_Area;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ResolutionAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Resolution_Area::factory(4)->create();
    }
}
