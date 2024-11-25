<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Factories\Resolution_AreaFactory;

class ResolutionAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Resolution_AreaFactory::createOrderedResolution_Areas();
    }
}
