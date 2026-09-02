<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('formula')->default('mifflin');
            $table->decimal('weight_kg', 5, 2);
            $table->decimal('height_cm', 5, 2);
            $table->unsignedInteger('age');
            $table->string('gender')->default('male');
            $table->decimal('activity_factor', 3, 2)->default(1.20);
            $table->unsignedInteger('bmr');
            $table->unsignedInteger('tdee');
            $table->unsignedInteger('target_calories');
            $table->unsignedInteger('protein_pct')->default(20);
            $table->unsignedInteger('carbs_pct')->default(50);
            $table->unsignedInteger('fat_pct')->default(30);
            $table->string('status')->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diets');
    }
};
