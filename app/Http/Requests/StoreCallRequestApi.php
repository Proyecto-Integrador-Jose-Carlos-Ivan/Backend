<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            //
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
