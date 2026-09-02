<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('anthropometric_records', function (Blueprint $table) {
            $table->id();

            // Relación 1 a Muchos: Sin unique(), un paciente tiene muchas evaluaciones
            $table->foreignId('patient_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->date('measured_at');

            // Medidas físicas y cálculo de IMC
            $table->decimal('weight', 5, 2)->nullable(); // ej: 120.50 kg
            $table->decimal('height', 3, 2)->nullable(); // ej: 1.75 m
            $table->decimal('bmi', 5, 2)->nullable();    // ej: 24.49

            // Composición corporal
            $table->decimal('waist_circumference', 5, 2)->nullable();
            $table->decimal('body_fat', 5, 2)->nullable();
            $table->decimal('muscle_mass', 5, 2)->nullable();
            $table->decimal('visceral_fat', 5, 2)->nullable();
            $table->decimal('water_percentage', 5, 2)->nullable();
            $table->decimal('bone_mass', 5, 2)->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anthropometric_records');
    }
};
