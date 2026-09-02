<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Food extends Model
{
    protected $table = 'foods';

    protected $fillable = [
        'name',
        'category',
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

    public function mealItems(): HasMany
    {
        return $this->hasMany(DietMealItem::class);
    }
}
