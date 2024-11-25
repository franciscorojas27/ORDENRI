<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Factories\GeneralManagementsFactory;

class GeneralManagementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GeneralManagementsFactory::createOrderedGeneralManagements();
    }
}
