<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreCallRequest",
 *     title="Store Call Request",
 *     description="Store Call request body data",
 *     required={"fecha_hora", "operador_id", "paciente_id", "descripcion", "sentido", "categoria", "subtipo"},
 *     @OA\Property(property="fecha_hora", type="string", format="date-time", description="Call date and time"),
 *     @OA\Property(property="operador_id", type="integer", description="Operator ID"),
 *     @OA\Property(property="paciente_id", type="integer", description="Patient ID"),
 *     @OA\Property(property="descripcion", type="string", description="Call description"),
 *     @OA\Property(property="sentido", type="string", enum={"entrante", "saliente"}, description="Call direction"),
 *     @OA\Property(property="categoria", type="string", description="Call category"),
 *     @OA\Property(property="subtipo", type="string", description="Call subtype"),
 *     @OA\Property(property="aviso_id", type="integer", description="Alert ID"),
 *     @OA\Property(property="zone_id", type="integer", description="Zone ID")
 * )
 */
class StoreCallRequestApi extends FormRequest
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
            'fecha_hora' => 'required|date',
            'operador_id' => 'required|exists:users,id',
            'paciente_id' => 'required|exists:pacientes,id',
            'descripcion' => 'nullable|string',
            'sentido' => 'required|in:entrante,saliente',
            'categoria' => 'required|string',
            'subtipo' => 'required|string',
            'aviso_id' => 'nullable|exists:avisos,id',
            'zone_id' => 'nullable|exists:zonas,id',
        ];
    }

    public function messages()
    {
        return [
            'fecha_hora.required' => 'La fecha y hora son obligatorias.',
            'fecha_hora.date' => 'La fecha y hora deben ser una fecha válida.',
            'operador_id.required' => 'El ID del operador es obligatorio.',
            'operador_id.exists' => 'El ID del operador no existe.',
            'paciente_id.required' => 'El ID del paciente es obligatorio.',
            'paciente_id.exists' => 'El ID del paciente no existe.',
            'sentido.required' => 'El sentido de la llamada es obligatorio.',
            'sentido.in' => 'El sentido de la llamada debe ser entrante o saliente.',
            'categoria.required' => 'La categoría es obligatoria.',
            'categoria.in' => 'La categoría no es válida.',
            'subtipo.in' => 'El subtipo no es válido.',
            'aviso_id.exists' => 'El ID del aviso no existe.',
        ];
    }
}