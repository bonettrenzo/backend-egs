<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre'      => 'sometimes|string|max:150',
            'descripcion' => 'sometimes|string',
            'precio'      => 'sometimes|numeric|min:0.01',
            'stock'       => 'sometimes|integer|min:0',
            'categoria'   => 'sometimes|string|max:80',
        ];
    }
}
