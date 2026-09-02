<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Patient extends Model
{
    /**
     * Géneros permitidos.
     */
    public const GENDER_MALE = 'male';
    public const GENDER_FEMALE = 'female';

    public const GENDERS = [
        self::GENDER_MALE,
        self::GENDER_FEMALE,
    ];

    protected $table = 'patients';

    protected $fillable = [
        'first_name',
        'last_name',
        'dni',
        'email',
        'phone',
        'birth_date',
        'gender',
        'occupation',
        'address',
        'active',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'active' => 'boolean',
    ];

    protected $appends = [
        'age',
        'full_name',
        'last_record',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Historia clínica del paciente.
     */
    public function clinicalHistory(): HasOne
    {
        return $this->hasOne(ClinicalHistory::class);
    }

    /**
     * Registros antropométricos del paciente.
     */
    public function anthropometricRecords(): HasMany
    {
        return $this->hasMany(AnthropometricRecord::class)
            ->latest('measured_at');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    /**
     * Nombre completo.
     */
    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    /**
     * Nombre mostrado en tablas y selects.
     */
    public function getDisplayNameAttribute(): string
    {
        return "{$this->full_name} ({$this->dni})";
    }

    /**
     * Edad calculada automáticamente.
     */
    public function getAgeAttribute(): int
    {
        return $this->birth_date?->age ?? 0;
    }

    /**
     * Obtener la última evaluación antropométrica.
     */
    public function getLastRecordAttribute()
    {
        return $this->anthropometricRecords->first();
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Pacientes activos.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }

    /**
     * appointments - Agenda
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }


    public function latestAnthropometry(): HasOne
    {
        return $this->hasOne(AnthropometricRecord::class)->latestOfMany();
    }
}
