<?php


namespace Database\Factories;

use App\Models\User;
use App\Models\Patient;
use App\Models\Alert;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Zone;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Call>
 */
class CallFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fecha_hora' => fake()->dateTime(),
            'operador_id' => User::factory(),
            'paciente_id' => Patient::factory(),
            'descripcion' => fake()->text(),
            'sentido' => fake()->randomElement(['entrante', 'saliente']),
            'categoria' => fake()->randomElement(['atencion_emergencias', 'comunicaciones_no_urgentes', 'no_planificada', 'planificada']),
            'subtipo' => fake()->optional()->randomElement(['emergencias_sociales', 'emergencias_sanitarias', 'emergencias_crisis_soledad', 'emergencias_alarma_sin_respuesta', 'notificar_ausencias', 'modificar_datos', 'llamadas_accidentales', 'peticion_informacion', 'sugerencias_quejas', 'llamadas_sociales', 'registrar_citas', 'otros']),
            'aviso_id' => Alert::factory(),
            'zone_id' => Zone::factory(),
        ];
    }
}
