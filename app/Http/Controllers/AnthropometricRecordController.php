<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnthropometricRecordRequest;
use App\Models\AnthropometricRecord;
use App\Models\Patient;
use Illuminate\Http\JsonResponse;

class AnthropometricRecordController extends Controller
{
    /**
     * Listar el historial de evaluaciones antropométricas de un paciente.
     */
    public function index(Patient $patient): JsonResponse
    {
        $records = $patient->anthropometricRecords()->latest('measured_at')->get();

        return response()->json($records);
    }

    /**
     * Registrar una nueva evaluación antropométrica.
     */
    public function store(StoreAnthropometricRecordRequest $request, Patient $patient): JsonResponse
    {
        // Se asocia directamente la evaluación al paciente usando la relación HasMany
        $record = $patient->anthropometricRecords()->create($request->validated());

        return response()->json([
            'message' => 'Registro antropométrico guardado exitosamente',
            'data'    => $record,
        ], 201);
    }

    /**
     * Eliminar una evaluación específica.
     */
    public function destroy(AnthropometricRecord $anthropometricRecord): JsonResponse
    {
        $anthropometricRecord->delete();

        return response()->json([
            'message' => 'Registro antropométrico eliminado correctamente',
        ]);
    }
}
