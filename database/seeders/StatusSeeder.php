<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Factories\StatusFactory;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StatusFactory::createOrderedStatuses();
    }
}
