<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="StoreAlertRequest",
 *     title="Store Alert Request",
 *     description="Store Alert request body data",
 *     required={"recurrencia", "tipo", "subtipo", "operador_id", "paciente_id"},
 *     @OA\Property(property="recurrencia", type="string", enum={"puntual", "periodic"}, description="Alert recurrence (puntual/periodic)"),
 *     @OA\Property(property="tipo", type="string", enum={"avisos", "protocolos", "ausencias_retornos"}, description="Alert type"),
 *     @OA\Property(property="subtipo", type="string", description="Alert subtype"),
 *     @OA\Property(property="fecha", type="string", format="date", nullable=true, description="Alert date"),
 *     @OA\Property(property="dia_semana", type="integer", nullable=true, description="Day of the week (1-7)"),
 *     @OA\Property(property="descripcion", type="string", nullable=true, description="Alert description"),
 *     @OA\Property(property="operador_id", type="integer", description="Operator ID"),
 *     @OA\Property(property="paciente_id", type="integer", description="Patient ID"),
 *     @OA\Property(property="zona_id", type="integer", nullable=true, description="Zone ID")
 * )
 */
class StoreAlertRequestApi extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'recurrencia' => 'required|in:puntual,periodic',
            'tipo' => 'required|in:avisos,protocolos,ausencias_retornos',
            'subtipo' => [
                'required',
                Rule::in($this->allowedSubtipos()),
            ],
            'fecha' => 'nullable|date',
            'dia_semana' => 'nullable|integer|min:1|max:7',
            'operador_id' => 'required|exists:users,id',
            'paciente_id' => 'required|exists:pacientes,id',
            'zona_id' => 'nullable|exists:zonas,id',
        ];
    }

    protected function allowedSubtipos(): array
    {
        $tipo = $this->input('tipo');

        return match ($tipo) {
            'avisos' => ['medicacion', 'especial'],
            'protocolos' => ['emergencias', 'duelo', 'alta_hospitalaria'],
            'ausencias_retornos' => ['suspension', 'retorn', 'fi_ausencia'],
            default => [],
        };
    }
}