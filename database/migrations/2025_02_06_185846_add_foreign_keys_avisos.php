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
        Schema::table('avisos', function (Blueprint $table) {
            $table->unsignedBigInteger('operador_id');

            $table->foreign('operador_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');

                    
            $table->unsignedBigInteger('paciente_id');

            $table->foreign('paciente_id')
                  ->references('id')
                  ->on('pacientes')
                  ->onDelete('cascade');

            
            $table->unsignedBigInteger('zona_id');

            $table->foreign('zona_id')
                  ->references('id')
                  ->on('zonas')
                  ->onDelete('cascade')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avisos');
    }
};
