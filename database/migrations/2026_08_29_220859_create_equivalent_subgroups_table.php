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
        Schema::create('equivalent_subgroups', function (Blueprint $table) {
            $table->id();

            // Grupo al que pertenece el subgrupo
            $table->foreignId('equivalent_group_id')
                ->constrained('equivalent_groups')
                ->cascadeOnDelete();

            // Código interno
            $table->string('code', 50);

            // Nombre del subgrupo
            $table->string('name');

            // Descripción opcional
            $table->text('description')->nullable();

            // Orden de visualización
            $table->unsignedInteger('sort_order')->default(0);

            // Permite activar/desactivar subgrupos
            $table->boolean('active')->default(true);

            $table->timestamps();

            $table->unique([
                'equivalent_group_id',
                'code'
            ]);

            $table->index([
                'equivalent_group_id',
                'active'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equivalent_subgroups');
    }
};
