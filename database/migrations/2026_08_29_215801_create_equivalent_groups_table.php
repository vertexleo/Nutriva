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
        Schema::create('equivalent_groups', function (Blueprint $table) {
            $table->id();

            // Código interno del grupo
            $table->string('code', 50)->unique();

            // Nombre visible para el nutricionista
            $table->string('name');

            // Descripción opcional
            $table->text('description')->nullable();

            // Orden de visualización
            $table->unsignedInteger('sort_order')->default(0);

            // Permite activar/desactivar grupos
            $table->boolean('active')->default(true);

            $table->timestamps();

            $table->index('active');
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equivalent_groups');
    }
};
