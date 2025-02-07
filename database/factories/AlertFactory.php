<?php


namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Patient;
use App\Models\Zone;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Alert>
 */
class AlertFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'recurrencia' => fake()->randomElement(['puntual', 'periodic']),
            'tipo' => fake()->randomElement(['avisos', 'protocolos', 'ausencias_retornos']),
            'subtipo' => fake()->randomElement(['medicacion', 'especial', 'emergencias', 'duelo', 'alta_hospitalaria', 'suspension', 'retorn', 'fi_ausencia']),
            'fecha' => fake()->date(),
            'dia_semana' => fake()->numberBetween(1, 7),
            'descripcion' => fake()->text(),
            'operador_id' => User::factory(),
            'paciente_id' => Patient::factory(),
            'zona_id' => Zone::factory(),
        ];
    }
}
