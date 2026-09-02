<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | Datos personales
            |--------------------------------------------------------------------------
            */

            'first_name' => [
                'required',
                'string',
                'max:100',
            ],

            'last_name' => [
                'required',
                'string',
                'max:100',
            ],

            'dni' => [
                'required',
                'string',
                'max:20',
            ],

            'email' => [
                'nullable',
                'email',
                'max:150',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'birth_date' => [
                'nullable',
                'date',
            ],

            'gender' => [
                'nullable',
                'string',
                'max:20',
            ],

            'occupation' => [
                'nullable',
                'string',
                'max:100',
            ],

            'address' => [
                'nullable',
                'string',
                'max:255',
            ],

            'active' => [
                'nullable',
                'boolean',
            ],


            /*
            |--------------------------------------------------------------------------
            | Historia clínica
            |--------------------------------------------------------------------------
            */

            'clinical_history' => [
                'nullable',
                'array',
            ],

            'clinical_history.diseases' => [
                'nullable',
                'string',
            ],

            'clinical_history.medications' => [
                'nullable',
                'string',
            ],

            'clinical_history.allergies' => [
                'nullable',
                'string',
            ],

            'clinical_history.goals' => [
                'nullable',
                'string',
            ],

            'clinical_history.physical_activity' => [
                'nullable',
                'string',
                'max:50',
            ],

            'clinical_history.smoking' => [
                'nullable',
                'boolean',
            ],

            'clinical_history.alcohol' => [
                'nullable',
                'boolean',
            ],

            'clinical_history.sleep_hours' => [
                'nullable',
                'integer',
                'min:0',
                'max:24',
            ],

            'clinical_history.observations' => [
                'nullable',
                'string',
            ],


            /*
            |--------------------------------------------------------------------------
            | Evaluación antropométrica
            |--------------------------------------------------------------------------
            */

            'anthropometric_record' => [
                'nullable',
                'array',
            ],

            'anthropometric_record.measured_at' => [
                'nullable',
                'date',
            ],

            'anthropometric_record.weight' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'anthropometric_record.height' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'anthropometric_record.waist_circumference' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'anthropometric_record.body_fat' => [
                'nullable',
                'numeric',
                'min:0',
                'max:100',
            ],

            'anthropometric_record.muscle_mass' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'anthropometric_record.visceral_fat' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'anthropometric_record.water_percentage' => [
                'nullable',
                'numeric',
                'min:0',
                'max:100',
            ],

            'anthropometric_record.bone_mass' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'anthropometric_record.notes' => [
                'nullable',
                'string',
            ],
        ];
    }
}
