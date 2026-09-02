<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDietRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Cabecera de la Dieta
            'patient_id' => ['required', 'integer', 'exists:patients,id'],
            'name' => ['required', 'string', 'max:255'],
            'formula' => ['required', 'string', Rule::in(['mifflin', 'harris_benedict', 'katch_mcardle'])],
            'weight_kg' => ['required', 'numeric', 'min:1', 'max:500'],
            'height_cm' => ['required', 'numeric', 'min:30', 'max:300'],
            'age' => ['required', 'integer', 'min:1', 'max:120'],
            'gender' => ['required', 'string', Rule::in(['male', 'female'])],
            'activity_factor' => ['required', 'numeric', 'min:1', 'max:3'],
            'bmr' => ['required', 'integer', 'min:0'],
            'tdee' => ['required', 'integer', 'min:0'],
            'target_calories' => ['required', 'integer', 'min:500', 'max:10000'],
            'protein_pct' => ['required', 'integer', 'min:0', 'max:100'],
            'carbs_pct' => ['required', 'integer', 'min:0', 'max:100'],
            'fat_pct' => ['required', 'integer', 'min:0', 'max:100'],
            'status' => ['required', 'string', Rule::in(['active', 'completed', 'draft'])],
            'notes' => ['nullable', 'string', 'max:2000'],

            // Cuadro de Equivalentes
            'equivalents' => ['nullable', 'array'],
            'equivalents.*.group_key' => ['required_with:equivalents', 'string'],
            'equivalents.*.servings' => ['required_with:equivalents', 'numeric', 'min:0'],

            // Tiempos de Comida
            'meals' => ['nullable', 'array'],
            'meals.*.name' => ['required_with:meals', 'string', 'max:255'],
            'meals.*.order' => ['nullable', 'integer'],
            'meals.*.notes' => ['nullable', 'string'],

            // Alimentos dentro de cada comida
            'meals.*.items' => ['nullable', 'array'],
            'meals.*.items.*.food_id' => ['nullable', 'exists:foods,id'],
            'meals.*.items.*.name' => ['required_with:meals.*.items', 'string', 'max:255'],
            'meals.*.items.*.portion' => ['required_with:meals.*.items', 'numeric', 'min:0.01'],
            'meals.*.items.*.unit' => ['required_with:meals.*.items', 'string', 'max:50'],
            'meals.*.items.*.calories' => ['required_with:meals.*.items', 'numeric', 'min:0'],
            'meals.*.items.*.protein' => ['required_with:meals.*.items', 'numeric', 'min:0'],
            'meals.*.items.*.carbs' => ['required_with:meals.*.items', 'numeric', 'min:0'],
            'meals.*.items.*.fat' => ['required_with:meals.*.items', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'patient_id.required' => 'Debes seleccionar un paciente.',
            'patient_id.exists' => 'El paciente seleccionado no existe.',
            'name.required' => 'El nombre del plan es obligatorio.',
            'target_calories.required' => 'Debes especificar las calorías objetivo.',
            'target_calories.min' => 'El plan debe tener al menos 500 kcal.',
        ];
    }
}
