<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Factories\TypeFactory;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TypeFactory::createOrderedTypes();
    }
}
