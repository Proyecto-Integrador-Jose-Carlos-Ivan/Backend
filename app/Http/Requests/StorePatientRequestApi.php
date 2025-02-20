<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StorePatientRequest",
 *     title="Store Patient Request",
 *     description="Store Patient request body data",
 *      required={"nombre", "fecha_nacimiento", "direccion", "dni", "sip", "telefono", "email", "zona_id"},
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
class StorePatientRequestApi extends FormRequest
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
            'nombre' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'direccion' => 'required|string|max:255',
            'dni' => 'required|string|max:20|unique:pacientes',
            'sip' => 'required|integer|unique:pacientes',
            'telefono' => 'required|integer',
            'email' => 'required|string|email|max:255|unique:pacientes',
            'zona_id' => 'required|exists:zonas,id',
            'contacto_id' => 'nullable|exists:contactos,id',
            'situacion_personal' => 'nullable|string',
            'situacion_sanitaria' => 'nullable|string',
            'situacion_habitage' => 'nullable|string',
            'autonomia' => 'nullable|string',
            'situacion_economica' => 'nullable|string'
        ];
    }
}