<?php


namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'administrador',
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'avila51jose@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'administrador',
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'carga.romero2004@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'administrador',
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'ivanjuan2006@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'administrador',
        ]);
        User::factory(10)->create();
    }
}
