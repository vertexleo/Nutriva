<?php

use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DietController;
use App\Http\Controllers\FoodController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | Pacientes
    |--------------------------------------------------------------------------
    */

    Route::resource('patients', PatientController::class);


    /*
    |--------------------------------------------------------------------------
    | Perfil
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');


    /*
    |--------------------------------------------------------------------------
    | Módulos
    |--------------------------------------------------------------------------
    */

    Route::resource('appointments', AppointmentController::class);

    Route::resource('diets', DietController::class);

    // Rutas del Catálogo de Alimentos
    Route::resource('foods', FoodController::class)->except(['create', 'edit', 'show']);

    Route::get('/reports', fn () => inertia('Reports/Index'))
        ->name('reports.index');

    Route::get('/settings', fn () => inertia('Settings/Index'))
        ->name('settings.index');
});

require __DIR__.'/auth.php';
