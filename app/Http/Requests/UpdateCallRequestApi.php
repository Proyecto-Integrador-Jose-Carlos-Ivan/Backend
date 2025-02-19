<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="UpdateCallRequest",
 *     title="Update Call Request",
 *     description="Update Call request body data",
 *     @OA\Property(property="fecha_hora", type="string", format="date-time", description="Call date and time"),
 *     @OA\Property(property="operador_id", type="integer", description="Operator ID"),
 *     @OA\Property(property="paciente_id", type="integer", description="Patient ID"),
 *     @OA\Property(property="descripcion", type="string", description="Call description"),
 *     @OA\Property(property="sentido", type="string", description="Call direction (entrante/saliente)"),
 *     @OA\Property(property="categoria", type="string", description="Call category"),
 *     @OA\Property(property="subtipo", type="string", description="Call subtype"),
 *     @OA\Property(property="aviso_id", type="integer", description="Alert ID"),
 *     @OA\Property(property="zone_id", type="integer", description="Zone ID")
 * )
 */
class UpdateCallRequestApi extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fecha_hora' => 'date',
            'operador_id' => 'exists:users,id',
            'paciente_id' => 'exists:pacientes,id',
            'sentido' => 'in:entrante,saliente',
            'categoria' => [
                Rule::in(['atencion_emergencias', 'comunicaciones_no_urgentes', 'no_planificada', 'planificada']),
            ],
            'subtipo' => [
                'nullable',
                Rule::in($this->allowedSubtipos()),
                function ($attribute, $value, $fail) {
                    $categoria = $this->input('categoria');
                    if (in_array($categoria, ['no_planificada', 'planificada']) && $value !== null) {
                        $fail('El subtipo debe ser nulo para las categorías no_planificada y planificada.');
                    }
                     if ($categoria === 'atencion_emergencias' && !in_array($value, ['emergencias_sociales', 'emergencias_sanitarias', 'emergencias_crisis_soledad',   'emergencias_alarma_sin_respuesta']) && $value !== null) {
                         $fail('El subtipo no es válido para la categoría atencion_emergencias.');
                     }
                     if ($categoria === 'comunicaciones_no_urgentes' && !in_array($value, ['notificar_ausencias', 'modificar_datos', 'llamadas_accidentales', 'peticion_informacion', 'sugerencias_quejas', 'llamadas_sociales', 'registrar_citas', 'otros']) && $value !== null) {
                         $fail('El subtipo no es válido para la categoría comunicaciones_no_urgentes.');
                     }
                },
            ],
            'aviso_id' => 'nullable|exists:avisos,id',
        ];
    }

    protected function allowedSubtipos(): array
    {
        $categoria = $this->input('categoria');

        return match ($categoria) {
            'atencion_emergencias' => [
                'emergencias_sociales',
                'emergencias_sanitarias',
                'emergencias_crisis_soledad',
                'emergencias_alarma_sin_respuesta',
            ],
            'comunicaciones_no_urgentes' => [
                'notificar_ausencias',
                'modificar_datos',
                'llamadas_accidentales',
                'peticion_informacion',
                'sugerencias_quejas',
                'llamadas_sociales',
                'registrar_citas',
                'otros'
            ],
            default => [],
        };
    }
    public function messages()
    {
        return [
            'fecha_hora.date' => 'La fecha y hora deben ser una fecha válida.',
            'operador_id.exists' => 'El ID del operador no existe.',
            'paciente_id.exists' => 'El ID del paciente no existe.',
            'sentido.in' => 'El sentido de la llamada debe ser entrante o saliente.',
            'categoria.in' => 'La categoría no es válida.',
            'subtipo.in' => 'El subtipo no es válido.',
            'aviso_id.exists' => 'El ID del aviso no existe.',
        ];
    }
}