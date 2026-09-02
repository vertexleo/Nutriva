<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAppointmentRequest extends FormRequest
{
    /**
     * Autorizar la petición.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación.
     */
    public function rules(): array
    {
        return [
            'patient_id' => [
                'required',
                'integer',
                'exists:patients,id',
            ],

            'appointment_date' => [
                'required',
                'date',
            ],

            'appointment_time' => [
                'required',
                'date_format:H:i',
            ],

            'type' => [
                'required',
                'string',
                Rule::in([
                    'initial',
                    'followup',
                    'anthropometric',
                    'control',
                    // Se pueden conservar los textos completos por compatibilidad:
                    'Primera consulta',
                    'Seguimiento',
                    'Evaluación antropométrica',
                    'Control nutricional',
                ]),
            ],

            'status' => [
                'required',
                'string',
                Rule::in([
                    'scheduled',
                    'confirmed',
                    'attended',
                    'cancelled',
                    'no_show',
                ]),
            ],

            'notes' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ];
    }

    /**
     * Mensajes personalizados.
     */
    public function messages(): array
    {
        return [
            'patient_id.required' => 'Debes seleccionar un paciente.',
            'patient_id.exists' => 'El paciente seleccionado no existe.',

            'appointment_date.required' => 'La fecha de la cita es obligatoria.',
            'appointment_date.date' => 'La fecha de la cita no es válida.',

            'appointment_time.required' => 'La hora de la cita es obligatoria.',
            'appointment_time.date_format' => 'La hora debe tener el formato HH:MM.',

            'type.required' => 'Debes seleccionar el tipo de consulta.',
            'type.in' => 'El tipo de consulta seleccionado no es válido.',

            'status.required' => 'Debes seleccionar el estado de la cita.',
            'status.in' => 'El estado seleccionado no es válido.',

            'notes.max' => 'Las notas no pueden superar los 2000 caracteres.',
        ];
    }
}
