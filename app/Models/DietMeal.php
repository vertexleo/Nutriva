<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DietMeal extends Model
{
    protected $table = 'diet_meals';

    protected $fillable = [
        'diet_id',
        'name',
        'order',
        'notes',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    public function diet(): BelongsTo
    {
        return $this->belongsTo(Diet::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(DietMealItem::class);
    }
}
