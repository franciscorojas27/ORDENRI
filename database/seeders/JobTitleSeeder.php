<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Factories\JobTitleFactory;

class JobTitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JobTitleFactory::createOrderedJobTitles();
    }
}
