<?php


namespace Database\Seeders;

use App\Models\ContactPerson;
use Illuminate\Database\Seeder;

class ContactPersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactPerson::factory(30)->create();
    }
}
