<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnthropometricRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_id'          => ['required', 'exists:patients,id'],
            'measured_at'         => ['required', 'date'],
            'weight'              => ['nullable', 'numeric', 'min:0', 'max:500'],
            'height'              => ['nullable', 'numeric', 'min:0', 'max:3'],
            'waist_circumference' => ['nullable', 'numeric', 'min:0'],
            'body_fat'            => ['nullable', 'numeric', 'min:0', 'max:100'],
            'muscle_mass'         => ['nullable', 'numeric', 'min:0'],
            'visceral_fat'        => ['nullable', 'numeric', 'min:0'],
            'water_percentage'    => ['nullable', 'numeric', 'min:0', 'max:100'],
            'bone_mass'           => ['nullable', 'numeric', 'min:0'],
            'notes'               => ['nullable', 'string'],
        ];
    }
}
