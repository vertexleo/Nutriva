<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DietMealItem extends Model
{
    protected $table = 'diet_meal_items';

    protected $fillable = [
        'diet_meal_id',
        'food_id',
        'name',
        'portion',
        'unit',
        'calories',
        'protein',
        'carbs',
        'fat',
    ];

    protected $casts = [
        'portion' => 'float',
        'calories' => 'float',
        'protein' => 'float',
        'carbs' => 'float',
        'fat' => 'float',
    ];

    public function meal(): BelongsTo
    {
        return $this->belongsTo(
            DietMeal::class,
            'diet_meal_id'
        );
    }

    public function food(): BelongsTo
    {
        return $this->belongsTo(Food::class);
    }
}
