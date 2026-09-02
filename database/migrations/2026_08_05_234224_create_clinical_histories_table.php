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
        Schema::create('clinical_histories', function (Blueprint $table) {

            $table->id();

            $table->foreignId('patient_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->text('diseases')->nullable();

            $table->text('medications')->nullable();

            $table->text('allergies')->nullable();

            $table->text('goals')->nullable();

            $table->text('physical_activity')->nullable();

            $table->boolean('smoking')->default(false);

            $table->boolean('alcohol')->default(false);

            $table->unsignedTinyInteger('sleep_hours')->nullable();

            $table->text('observations')->nullable();

            $table->timestamps();

            // Un paciente solo puede tener una historia clínica
            $table->unique('patient_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinical_histories');
    }
};
