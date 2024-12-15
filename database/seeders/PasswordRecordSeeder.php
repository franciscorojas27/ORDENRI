<?php

namespace Database\Seeders;

use App\Models\PasswordRecords;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PasswordRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PasswordRecords::factory(4)->create();
    }
}
