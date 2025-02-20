<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellidos')->nullable();
            $table->date('fecha_nacimiento');
            $table->string('direccion');
            $table->string('dni')->unique();
            $table->integer('sip')->unique();
            $table->integer('telefono');
            $table->string('email')->unique();
            $table->unsignedBigInteger('zona_id');
            $table->text('situacion_personal')->nullable();
            $table->text('situacion_sanitaria')->nullable();
            $table->text('situacion_habitage')->nullable();
            $table->text('autonomia')->nullable();
            $table->text('situacion_economica')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
