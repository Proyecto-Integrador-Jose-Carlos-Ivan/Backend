<?php


namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContactPerson>
 */
class ContactPersonFactory extends Factory
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
            'apellido' => fake()->lastName(),
            'telefono' => fake()->phoneNumber(),
            'relacion' => fake()->randomElement(['Family', 'Friend', 'Neighbor']),
            'paciente_id' => Patient::factory(),
        ];
    }
}
