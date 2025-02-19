<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdatePatientRequest",
 *     title="Update Patient Request",
 *     description="Update Patient request body data",
 *     @OA\Property(property="nombre", type="string", maxLength=255, description="Patient name"),
 *     @OA\Property(property="fecha_nacimiento", type="string", format="date", description="Patient birth date"),
 *     @OA\Property(property="direccion", type="string", maxLength=255, description="Patient address"),
 *     @OA\Property(property="dni", type="string", maxLength=20, description="Patient DNI"),
 *     @OA\Property(property="sip", type="integer", description="Patient SIP"),
 *     @OA\Property(property="telefono", type="integer", description="Patient phone number"),
 *     @OA\Property(property="email", type="string", format="email", maxLength=255, description="Patient email"),
 *     @OA\Property(property="zona_id", type="integer", description="Zone ID"),
 *     @OA\Property(property="contacto_id", type="integer", description="Contact ID"),
 *     @OA\Property(property="situacion_personal", type="string", description="Patient personal situation"),
 *     @OA\Property(property="situacion_sanitaria", type="string", description="Patient health situation"),
 *     @OA\Property(property="situacion_habitage", type="string", description="Patient housing situation"),
 *     @OA\Property(property="autonomia", type="string", description="Patient autonomy level"),
 *     @OA\Property(property="situacion_economica", type="string", description="Patient economic situation")
 * )
 */
class UpdatePatientRequestApi extends FormRequest
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
            'nombre' => 'string|max:255',
            'fecha_nacimiento' => 'date',
            'direccion' => 'string|max:255',
            'dni' => 'string|max:20|unique:pacientes,dni,' . $this->route('patient'),
            'sip' => 'integer|unique:pacientes,sip,' . $this->route('patient'),
            'telefono' => 'integer',
            'email' => 'string|email|max:255|unique:pacientes,email,' . $this->route('patient'),
            'zona_id' => 'exists:zonas,id',
        ];
    }
}