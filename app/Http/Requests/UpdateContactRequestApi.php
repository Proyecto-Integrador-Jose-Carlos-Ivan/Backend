<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateContactRequest",
 *     title="Update Contact Request",
 *     description="Update Contact request body data",
 *     @OA\Property(property="nombre", type="string", maxLength=255, description="Contact name"),
 *     @OA\Property(property="apellido", type="string", maxLength=255, description="Contact last name"),
 *     @OA\Property(property="telefono", type="string", maxLength=20, description="Contact phone number"),
 *     @OA\Property(property="relacion", type="string", maxLength=255, description="Relationship to patient")
 * )
 */
class UpdateContactRequestApi extends FormRequest
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
            'apellido' => 'string|max:255',
            'telefono' => 'string|max:20',
            'relacion' => 'string|max:255',
        ];
    }
}