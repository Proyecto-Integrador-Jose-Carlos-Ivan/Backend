<?php

namespace Database\Seeders;

use App\Models\UserZona;
use Illuminate\Database\Seeder;

class UserZonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserZona::factory(50)->create();
    }
}