<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diet_meal_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diet_meal_id')->constrained()->cascadeOnDelete();
            $table->foreignId('food_id')->nullable()->constrained('foods')->nullOnDelete();
            $table->string('name');
            $table->decimal('portion', 6, 2)->default(1.00);
            $table->string('unit')->nullable();
            $table->decimal('calories', 6, 2)->default(0.00);
            $table->decimal('protein', 6, 2)->default(0.00);
            $table->decimal('carbs', 6, 2)->default(0.00);
            $table->decimal('fat', 6, 2)->default(0.00);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diet_meal_items');
    }
};
