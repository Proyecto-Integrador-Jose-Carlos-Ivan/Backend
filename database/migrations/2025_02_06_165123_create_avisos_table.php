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
        Schema::create('avisos', function (Blueprint $table) {
            $table->id();

            $table->enum('recurrencia', ['puntual', 'periodic']);

            $table->enum('tipo', ['avisos', 'protocolos','ausencias_retornos']);
            // subtipo dependiente de 'tipo'
            // - avisos -> [medicacion, especial]
            // - protocolos -> [emergencias, duelo, alta_hospitalaria]
            // - ausencias_retornos -> [suspension, retorn, fi_ausencia]
            $table->enum('subtipo', [
                'medicacion',
                'especial',
                'emergencias',
                'duelo',
                'alta_hospitalaria',
                'suspension',
                'retorn',
                'fi_ausencia'
            ]);
            
            $table->date('fecha')->nullable();       // Per avis puntual
            $table->tinyInteger('dia_semana')->nullable(); // Per avis periòdic (valor 1-7)
            $table->text('descripcion')->nullable();
            $table->timestamps();
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
