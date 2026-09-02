<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('foods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category')->nullable(); // Ej: Verduras, Cereales, AOA, Lácteos
            $table->decimal('portion', 6, 2)->default(100.00);
            $table->string('unit')->default('g'); // g, ml, pza, taza
            $table->decimal('calories', 6, 2)->default(0.00);
            $table->decimal('protein', 6, 2)->default(0.00);
            $table->decimal('carbs', 6, 2)->default(0.00);
            $table->decimal('fat', 6, 2)->default(0.00);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foods');
    }
};
