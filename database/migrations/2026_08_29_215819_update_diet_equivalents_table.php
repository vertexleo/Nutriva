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
        Schema::table('diet_equivalents', function (Blueprint $table) {

            // Nueva relación con el subgrupo
            $table->foreignId('equivalent_subgroup_id')
                ->after('diet_id')
                ->constrained('equivalent_subgroups')
                ->cascadeOnDelete();

        });

        Schema::table('diet_equivalents', function (Blueprint $table) {

            // Ya no utilizaremos group_key
            $table->dropColumn('group_key');

        });

        Schema::table('diet_equivalents', function (Blueprint $table) {

            // Evita registrar dos veces el mismo subgrupo
            // dentro del mismo plan.
            $table->unique([
                'diet_id',
                'equivalent_subgroup_id'
            ]);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('diet_equivalents', function (Blueprint $table) {

            $table->dropUnique([
                'diet_id',
                'equivalent_subgroup_id'
            ]);

            $table->dropForeign([
                'equivalent_subgroup_id'
            ]);

            $table->dropColumn('equivalent_subgroup_id');

            $table->string('group_key')->after('diet_id');
        });
    }
};
