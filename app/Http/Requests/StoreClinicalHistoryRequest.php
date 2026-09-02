<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClinicalHistoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_id'        => ['required', 'exists:patients,id', 'unique:clinical_histories,patient_id'],
            'diseases'          => ['nullable', 'string'],
            'medications'       => ['nullable', 'string'],
            'allergies'         => ['nullable', 'string'],
            'goals'             => ['nullable', 'string'],
            'physical_activity' => ['nullable', 'string'],
            'smoking'           => ['boolean'],
            'alcohol'           => ['boolean'],
            'sleep_hours'       => ['nullable', 'integer', 'min:0', 'max:24'],
            'observations'      => ['nullable', 'string'],
        ];
    }
}
