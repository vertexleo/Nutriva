<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Diet extends Model
{
    protected $table = 'diets';

    protected $fillable = [
        'patient_id',
        'name',
        'formula',
        'weight_kg',
        'height_cm',
        'age',
        'gender',
        'activity_factor',
        'bmr',
        'tdee',
        'target_calories',
        'protein_pct',
        'carbs_pct',
        'fat_pct',
        'status',
        'notes',
    ];

    protected $casts = [
        'weight_kg' => 'float',
        'height_cm' => 'float',
        'age' => 'integer',

        'activity_factor' => 'float',

        'bmr' => 'float',
        'tdee' => 'float',
        'target_calories' => 'float',

        'protein_pct' => 'float',
        'carbs_pct' => 'float',
        'fat_pct' => 'float',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function equivalents(): HasMany
    {
        return $this->hasMany(DietEquivalent::class);
    }

    public function meals(): HasMany
    {
        return $this->hasMany(DietMeal::class)
            ->orderBy('order');
    }
}
