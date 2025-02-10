<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAlertRequestApi extends FormRequest
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
            'recurrencia' => 'sometimes|in:puntual,periodic',
            'tipo' => 'sometimes|in:avisos,protocolos,ausencias_retornos',
            'subtipo' => [
                'sometimes',
                Rule::in($this->allowedSubtipos()),
            ],
            'fecha' => 'nullable|date',
            'dia_semana' => 'nullable|integer|min:1|max:7',
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
