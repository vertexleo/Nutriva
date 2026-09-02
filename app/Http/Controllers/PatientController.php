<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Models\Patient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class PatientController extends Controller
{
    /**
     * Listado de pacientes.
     */
    public function index(): Response
    {
        return Inertia::render('Patients/Index', [
            'patients' => Patient::with([
                'clinicalHistory',
                'anthropometricRecords',
            ])
                ->latest()
                ->get(),
        ]);
    }

    /**
     * Formulario para crear paciente.
     */
    public function create(): Response
    {
        return Inertia::render('Patients/Create');
    }

    /**
     * Crear paciente + historia clínica + evaluación inicial.
     */
    public function store(StorePatientRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {

            /*
        |--------------------------------------------------------------------------
        | Datos personales
        |--------------------------------------------------------------------------
        */

            $patientData = $request->validated();

            unset(
                $patientData['clinical_history'],
                $patientData['anthropometric_record']
            );

            $patient = Patient::create($patientData);


            /*
        |--------------------------------------------------------------------------
        | Historia clínica
        |--------------------------------------------------------------------------
        */

            $clinicalHistory = $request->validated('clinical_history');

            if (!empty($clinicalHistory)) {

                $patient->clinicalHistory()->create(
                    $clinicalHistory
                );
            }


            /*
        |--------------------------------------------------------------------------
        | Evaluación antropométrica inicial
        |--------------------------------------------------------------------------
        */

            $anthropometricRecord = $request->validated(
                'anthropometric_record'
            );

            if (!empty($anthropometricRecord)) {

                if (empty($anthropometricRecord['measured_at'])) {
                    $anthropometricRecord['measured_at'] = now()->toDateString();
                }

                $patient->anthropometricRecords()->create(
                    $anthropometricRecord
                );
            }
        });

        return redirect()
            ->route('patients.index')
            ->with(
                'success',
                'Paciente, historia clínica y evaluación inicial guardados correctamente.'
            );
    }

    /**
     * Mostrar paciente.
     */
    public function show(Patient $patient): Response
    {
        return Inertia::render('Patients/Show', [
            'patient' => $patient->load([
                'clinicalHistory',
                'anthropometricRecords',
            ]),
        ]);
    }

    /**
     * Formulario de edición.
     */
    public function edit(Patient $patient): Response
    {
        return Inertia::render('Patients/Edit', [
            'patient' => $patient->load([
                'clinicalHistory',
                'anthropometricRecords',
            ]),
        ]);
    }

    /**
     * Actualizar paciente.
     */
    public function update(
        UpdatePatientRequest $request,
        Patient $patient
    ): RedirectResponse {

        DB::transaction(function () use ($request, $patient) {

            $data = $request->validated();

            $patientData = $data;

            unset(
                $patientData['clinical_history'],
                $patientData['anthropometric_record']
            );

            /*
             * Datos personales
             */
            $patient->update($patientData);


            /*
             * Historia clínica
             */
            if (!empty($data['clinical_history'])) {

                $patient->clinicalHistory()->updateOrCreate(
                    [
                        'patient_id' => $patient->id,
                    ],
                    $data['clinical_history']
                );
            }


            /*
             * Evaluación antropométrica
             *
             * En edición creamos una nueva evaluación,
             * porque necesitamos conservar el historial.
             */
            if (!empty($data['anthropometric_record'])) {

                $patient->anthropometricRecords()->create(
                    $data['anthropometric_record']
                );
            }
        });

        return redirect()
            ->route('patients.show', $patient)
            ->with('success', 'Paciente actualizado correctamente.');
    }

    /**
     * Eliminar paciente.
     */
    public function destroy(Patient $patient): RedirectResponse
    {
        $patient->delete();

        return redirect()
            ->route('patients.index')
            ->with('success', 'Paciente eliminado correctamente.');
    }
}
