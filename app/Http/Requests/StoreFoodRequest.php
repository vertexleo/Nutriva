<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFoodRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'portion' => ['required', 'numeric', 'min:0.01'],
            'unit' => ['required', 'string', 'max:50'],
            'calories' => ['required', 'numeric', 'min:0'],
            'protein' => ['required', 'numeric', 'min:0'],
            'carbs' => ['required', 'numeric', 'min:0'],
            'fat' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del alimento es obligatorio.',
            'portion.required' => 'Debes definir una porción base.',
            'unit.required' => 'Debes definir la unidad de medida (g, ml, pza, etc.).',
            'calories.required' => 'Las calorías son obligatorias.',
        ];
    }
}
