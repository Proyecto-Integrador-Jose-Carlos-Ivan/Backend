<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        ];
    }
}
