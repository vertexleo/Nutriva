<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClinicalHistory extends Model
{
    protected $table = 'clinical_histories';

    protected $fillable = [
        'patient_id',

        'diseases',
        'medications',
        'allergies',

        'goals',

        'physical_activity',

        'smoking',
        'alcohol',

        'sleep_hours',

        'observations',
    ];

    protected $casts = [
        'smoking' => 'boolean',
        'alcohol' => 'boolean',
        'sleep_hours' => 'integer',
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
}
