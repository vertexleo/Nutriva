<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DietEquivalent extends Model
{
    protected $table = 'diet_equivalents';

    protected $fillable = [
        'diet_id',
        'group_key',
        'servings',
    ];

    protected $casts = [
        'servings' => 'float',
    ];

    public function diet(): BelongsTo
    {
        return $this->belongsTo(Diet::class);
    }
}
