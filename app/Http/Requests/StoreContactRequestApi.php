<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreContactRequest",
 *     title="Store Contact Request",
 *     description="Store Contact request body data",
 *     required={"nombre", "apellido", "telefono", "relacion"},
 *     @OA\Property(property="nombre", type="string", maxLength=255, description="Contact name"),
 *     @OA\Property(property="apellido", type="string", maxLength=255, description="Contact last name"),
 *     @OA\Property(property="telefono", type="string", maxLength=20, description="Contact phone number"),
 *     @OA\Property(property="relacion", type="string", maxLength=255, description="Relationship to patient")
 * )
 */
class StoreContactRequestApi extends FormRequest
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
            'apellido' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'relacion' => 'required|string|max:255',
        ];
    }
}