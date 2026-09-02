<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFoodRequest;
use App\Models\Food;
use Inertia\Inertia;

class FoodController extends Controller
{
    public function index()
    {
        $foods = Food::latest()->get();

        return Inertia::render('Foods/Index', [
            'foods' => $foods,
        ]);
    }

    public function store(StoreFoodRequest $request)
    {
        Food::create($request->validated());

        return back()->with('message', 'Alimento registrado en el catálogo.');
    }

    public function update(StoreFoodRequest $request, Food $food)
    {
        $food->update($request->validated());

        return back()->with('message', 'Alimento actualizado.');
    }

    public function destroy(Food $food)
    {
        $food->delete();

        return back()->with('message', 'Alimento eliminado.');
    }
}
