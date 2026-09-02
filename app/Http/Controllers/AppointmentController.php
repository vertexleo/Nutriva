<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class AppointmentController extends Controller
{
    /**
     * Mostrar listado de citas.
     */
    public function index(): Response
    {
        $appointments = Appointment::with('patient')
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();

        return Inertia::render('Appointments/Index', [
            'appointments' => $appointments,
        ]);
    }

    /**
     * Mostrar formulario para crear una nueva cita.
     */
    public function create(): Response
    {
        return Inertia::render('Appointments/Create', [
            'patients' => Patient::active()
                ->orderBy('first_name')
                ->orderBy('last_name')
                ->get([
                    'id',
                    'first_name',
                    'last_name',
                    'dni',
                ]),
        ]);
    }

    /**
     * Guardar una nueva cita.
     */
    public function store(StoreAppointmentRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            Appointment::create($request->validated());
        });

        return redirect()
            ->route('appointments.index')
            ->with('success', 'Cita creada correctamente.');
    }

    /**
     * Mostrar una cita específica.
     */
    public function show(Appointment $appointment): Response
    {
        return Inertia::render('Appointments/Show', [
            'appointment' => $appointment->load('patient'),
        ]);
    }

    /**
     * Mostrar formulario para editar una cita.
     */
    public function edit(Appointment $appointment): Response
    {
        return Inertia::render('Appointments/Edit', [
            'appointment' => $appointment->load('patient'),

            'patients' => Patient::active()
                ->orderBy('first_name')
                ->orderBy('last_name')
                ->get([
                    'id',
                    'first_name',
                    'last_name',
                    'dni',
                ]),
        ]);
    }

    /**
     * Actualizar una cita.
     */
    public function update(
        UpdateAppointmentRequest $request,
        Appointment $appointment
    ): RedirectResponse {
        DB::transaction(function () use ($request, $appointment) {
            $appointment->update($request->validated());
        });

        return redirect()
            ->route('appointments.index')
            ->with('success', 'Cita actualizada correctamente.');
    }

    /**
     * Eliminar una cita.
     */
    public function destroy(Appointment $appointment): RedirectResponse
    {
        DB::transaction(function () use ($appointment) {
            $appointment->delete();
        });

        return redirect()
            ->route('appointments.index')
            ->with('success', 'Cita eliminada correctamente.');
    }
}
