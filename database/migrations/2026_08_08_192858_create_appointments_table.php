<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {

            $table->id();

            $table->foreignId('patient_id')
                ->constrained('patients')
                ->cascadeOnDelete();

            $table->date('appointment_date');

            $table->time('appointment_time');

            $table->string('type');

            $table->string('status')
                ->default('scheduled');

            $table->text('notes')
                ->nullable();

            $table->timestamps();

            $table->index([
                'appointment_date',
                'appointment_time',
            ]);

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
