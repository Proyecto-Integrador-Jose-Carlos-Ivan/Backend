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
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->date('fecha_nacimiento');
            $table->string('direccion');
            $table->string('dni');
            $table->integer('sip');
            $table->integer('telefono');
            $table->string('email');
            $table->unsignedBigInteger('zona_id');
            $table->foreign('zona_id')->references('id')->on('zonas')->onDelete('cascade');
            $table->string('situacion_personal');
            $table->string('situacion_sanitaria');
            $table->string('situacion_habitage');
            $table->string('autonomia');
            $table->string('situacion_economica');
            $table->foreign('contacto_id')->references('id')->on('contactos')->onDelete('cascade');
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
