<?php


namespace Database\Factories;

use App\Models\Zone;
use App\Models\ContactPerson;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => fake()->name(),
            'fecha_nacimiento' => fake()->date(),
            'direccion' => fake()->address(),
            'dni' => fake()->unique()->randomNumber(8),
            'sip' => fake()->unique()->randomNumber(8),
            'telefono' => fake()->numberBetween(100000000, 999999999),
            'email' => fake()->unique()->safeEmail(),
            'zona_id' => Zone::factory(),
            'situacion_personal' => fake()->text(),
            'situacion_sanitaria' => fake()->text(),
            'situacion_habitage' => fake()->text(),
            'autonomia' => fake()->text(),
            'situacion_economica' => fake()->text(),
        ];
    }
}
