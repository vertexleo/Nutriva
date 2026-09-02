<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnthropometricRecord extends Model
{
    protected $table = 'anthropometric_records';

    protected $fillable = [
        'patient_id',

        'measured_at',

        'weight',
        'height',
        'bmi',

        'waist_circumference',

        'body_fat',

        'muscle_mass',

        'visceral_fat',

        'water_percentage',

        'bone_mass',

        'notes',
    ];

    protected $casts = [
        'measured_at' => 'date',

        'weight' => 'float',
        'height' => 'float',
        'bmi' => 'float',

        'waist_circumference' => 'float',

        'body_fat' => 'float',

        'muscle_mass' => 'float',

        'visceral_fat' => 'float',

        'water_percentage' => 'float',

        'bone_mass' => 'float',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Model Events
    |--------------------------------------------------------------------------
    */

    protected static function booted(): void
    {
        self::saving(function (AnthropometricRecord $record) {

            if (
                $record->weight !== null &&
                $record->height !== null &&
                $record->height > 0
            ) {
                $record->bmi = round(
                    $record->weight / ($record->height * $record->height),
                    2
                );
            }

        });
    }
}
