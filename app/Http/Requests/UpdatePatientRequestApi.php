<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
