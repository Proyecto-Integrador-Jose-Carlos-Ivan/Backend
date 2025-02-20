<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ZoneSeeder::class,
            PatientSeeder::class,
            ContactPersonSeeder::class,
            AlertSeeder::class,
            CallSeeder::class,
            UserZonaSeeder::class,
            OperatorPatientSeeder::class,
        ]);
    }
}
