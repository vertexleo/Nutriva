<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDietRequest;
use App\Http\Requests\UpdateDietRequest;
use App\Models\Diet;
use App\Models\Food;
use App\Models\Patient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class DietController extends Controller
{
    /**
     * Listado de planes nutricionales.
     */
    public function index(): Response
    {
        $diets = Diet::with([
            'patient:id,first_name,last_name,dni',
        ])
            ->latest()
            ->get();

        return Inertia::render('Diets/Index', [
            'diets' => $diets,
        ]);
    }

    /**
 * Formulario para crear un plan nutricional.
 */
public function create(): Response
{
    $patients = Patient::select('id', 'first_name', 'last_name', 'dni', 'birth_date', 'gender')
        ->with('latestAnthropometry')
        ->orderBy('first_name')
        ->orderBy('last_name')
        ->get()
        ->makeHidden(['last_record']); // Oculta la relación pesada para evitar el N+1

    $foods = Food::query()
        ->orderBy('name')
        ->get();

    return Inertia::render('Diets/Create', [
        'patients' => $patients,
        'foods' => $foods,
    ]);
}

/**
 * Formulario de edición.
 */
public function edit(Diet $diet): Response
{
    $diet->load([
        'patient',
        'equivalents',
        'meals.items.food',
    ]);

    $patients = Patient::select('id', 'first_name', 'last_name', 'dni', 'birth_date', 'gender')
        ->with('latestAnthropometry')
        ->orderBy('first_name')
        ->orderBy('last_name')
        ->get()
        ->makeHidden(['last_record']);

    $foods = Food::query()
        ->orderBy('name')
        ->get();

    return Inertia::render('Diets/Edit', [
        'diet' => $diet,
        'patients' => $patients,
        'foods' => $foods,
    ]);
}

    /**
     * Guardar un nuevo plan nutricional.
     */
    public function store(StoreDietRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {

            $data = $request->validated();

            $diet = Diet::create(
                collect($data)
                    ->except(['equivalents', 'meals'])
                    ->toArray()
            );

            $this->syncEquivalents(
                $diet,
                $data['equivalents'] ?? []
            );

            $this->syncMeals(
                $diet,
                $data['meals'] ?? []
            );
        });

        return redirect()
            ->route('diets.index')
            ->with('success', 'Plan nutricional creado exitosamente.');
    }

    /**
     * Mostrar un plan nutricional.
     */
    public function show(Diet $diet): Response
    {
        $diet->load([
            'patient',
            'equivalents',
            'meals.items.food',
        ]);

        return Inertia::render('Diets/Show', [
            'diet' => $diet,
        ]);
    }



    /**
     * Actualizar un plan nutricional.
     */
    public function update(
        UpdateDietRequest $request,
        Diet $diet
    ): RedirectResponse {
        DB::transaction(function () use ($request, $diet) {

            $data = $request->validated();

            $diet->update(
                collect($data)
                    ->except(['equivalents', 'meals'])
                    ->toArray()
            );

            /*
            |--------------------------------------------------------------------------
            | Reemplazar equivalentes
            |--------------------------------------------------------------------------
            */

            if (array_key_exists('equivalents', $data)) {
                $diet->equivalents()->delete();

                $this->syncEquivalents(
                    $diet,
                    $data['equivalents'] ?? []
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Reemplazar comidas
            |--------------------------------------------------------------------------
            */

            if (array_key_exists('meals', $data)) {

                /*
                 * Eliminamos primero los items para no depender
                 * exclusivamente de ON DELETE CASCADE.
                 */
                foreach ($diet->meals()->get() as $meal) {
                    $meal->items()->delete();
                }

                $diet->meals()->delete();

                $this->syncMeals(
                    $diet,
                    $data['meals'] ?? []
                );
            }
        });

        return redirect()
            ->route('diets.show', $diet)
            ->with('success', 'Plan nutricional actualizado correctamente.');
    }

    /**
     * Eliminar un plan nutricional.
     */
    public function destroy(Diet $diet): RedirectResponse
    {
        DB::transaction(function () use ($diet) {

            /*
             * Eliminamos dependencias manualmente.
             */
            foreach ($diet->meals()->get() as $meal) {
                $meal->items()->delete();
            }

            $diet->meals()->delete();
            $diet->equivalents()->delete();

            $diet->delete();
        });

        return redirect()
            ->route('diets.index')
            ->with('success', 'Plan nutricional eliminado correctamente.');
    }

    /**
     * Guardar equivalentes del plan.
     */
    private function syncEquivalents(
        Diet $diet,
        array $equivalents
    ): void {
        foreach ($equivalents as $equivalent) {

            $diet->equivalents()->create([
                'group_key' => $equivalent['group_key'],
                'servings' => $equivalent['servings'],
            ]);
        }
    }

    /**
     * Guardar comidas e ingredientes.
     */
    private function syncMeals(
        Diet $diet,
        array $meals
    ): void {
        foreach ($meals as $index => $mealData) {

            $meal = $diet->meals()->create([
                'name' => $mealData['name'],
                'order' => $mealData['order'] ?? $index + 1,
                'notes' => $mealData['notes'] ?? null,
            ]);

            foreach ($mealData['items'] ?? [] as $itemData) {

                $meal->items()->create([
                    'food_id' => $itemData['food_id'] ?? null,
                    'name' => $itemData['name'] ?? null,
                    'portion' => $itemData['portion'],
                    'unit' => $itemData['unit'],
                    'calories' => $itemData['calories'] ?? 0,
                    'protein' => $itemData['protein'] ?? 0,
                    'carbs' => $itemData['carbs'] ?? 0,
                    'fat' => $itemData['fat'] ?? 0,
                ]);
            }
        }
    }
}
