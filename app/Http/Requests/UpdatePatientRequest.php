<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePatientRequest extends FormRequest
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
        // Obtiene el ID del paciente desde el parámetro de la ruta ({patient})
        $patientId = $this->route('patient')?->id ?? $this->route('patient');

        return [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['required', 'string', 'max:100'],
            'dni'        => [
                'required',
                'string',
                'max:20',
                Rule::unique('patients', 'dni')->ignore($patientId)
            ],
            'email'      => [
                'nullable',
                'email',
                'max:150',
                Rule::unique('patients', 'email')->ignore($patientId)
            ],
            'phone'      => ['nullable', 'string', 'max:20'],
            'birth_date' => ['required', 'date', 'before:today'],
            'gender'     => ['required', 'string', 'in:male,female,other'],
            'occupation' => ['nullable', 'string', 'max:100'],
            'address'    => ['nullable', 'string', 'max:255'],
        ];
    }
}
