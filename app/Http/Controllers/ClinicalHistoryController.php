<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClinicalHistoryRequest;
use App\Models\ClinicalHistory;
use App\Models\Patient;
use Illuminate\Http\JsonResponse;

class ClinicalHistoryController extends Controller
{
    /**
     * Mostrar la historia clínica de un paciente.
     */
    public function show(Patient $patient): JsonResponse
    {
        $history = $patient->clinicalHistory;

        if (!$history) {
            return response()->json(['message' => 'El paciente no posee historia clínica.'], 404);
        }

        return response()->json($history);
    }

    /**
     * Crear o actualizar la historia clínica del paciente.
     */
    public function storeOrUpdate(StoreClinicalHistoryRequest $request, Patient $patient): JsonResponse
    {
        // updateOrCreate garantiza mantener la relación 1 a 1
        $history = $patient->clinicalHistory()->updateOrCreate(
            ['patient_id' => $patient->id],
            $request->validated()
        );

        return response()->json([
            'message' => 'Historia clínica guardada exitosamente',
            'data'    => $history,
        ], 200);
    }
}
