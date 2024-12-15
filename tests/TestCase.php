<?php

namespace Tests;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Ejecutar migraciones y seeders solo una vez antes de todas las pruebas.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        \Illuminate\Support\Facades\Hash::setRounds(4);
        $this->artisan('migrate:fresh --seeder=DatabaseSeeder');
    }

}
