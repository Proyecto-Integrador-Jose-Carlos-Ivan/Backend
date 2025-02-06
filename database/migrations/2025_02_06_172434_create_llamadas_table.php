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
        Schema::create('llamadas', function (Blueprint $table) {
            $table->id();
            // Fecha y hora de realización
            $table->dateTime('fecha_hora');
            // Referencias
            $table->unsignedBigInteger('operador_id'); // El teleoperador que hace la llamada
            $table->unsignedBigInteger('paciente_id');  // El destinatario de la llamada
            // Campo libre de descripción
            $table->text('descripcion')->nullable();
            // Indica si la llamada es entrante o saliente
            $table->enum('sentido', ['entrante', 'saliente']);
            /*  
             * Para las llamadas entrantes:
             *   Categoría: 
             *     - 'atencion_emergencias' (con 4 subtipos)
             *     - 'comunicaciones_no_urgentes' (con 8 subtipos)
             * Para las llamadas salientes:
             *     - 'no_planificada'
             *     - 'planificada'
             */
            $table->enum('categoria', [
                'atencion_emergencias', 
                'comunicaciones_no_urgentes',
                'no_planificada',
                'planificada'
            ]);
            /*  
             * El campo subtipo recoge:
             *   Si la llamada es entrante y de tipo "atencion_emergencias":
             *     - 'emergencias_sociales'
             *     - 'emergencias_sanitarias'
             *     - 'emergencias_crisis_soledad'
             *     - 'emergencias_alarma_sin_respuesta'
             *   Si la llamada es entrante y de tipo "comunicaciones_no_urgentes":
             *     - 'notificar_ausencias'
             *     - 'modificar_datos'
             *     - 'llamadas_accidentales'
             *     - 'peticion_informacion'
             *     - 'sugerencias_quejas'
             *     - 'llamadas_sociales'
             *     - 'registrar_citas'
             *     - 'otros'
             * En las llamadas salientes no se utiliza (se puede dejar null).
             */
            $table->enum('subtipo', [
                'emergencias_sociales',
                'emergencias_sanitarias',
                'emergencias_crisis_soledad',
                'emergencias_alarma_sin_respuesta',
                'notificar_ausencias',
                'modificar_datos',
                'llamadas_accidentales',
                'peticion_informacion',
                'sugerencias_quejas',
                'llamadas_sociales',
                'registrar_citas',
                'otros'
            ])->nullable();
            // Si la llamada saliente es planificada, se asocia un aviso
            $table->unsignedBigInteger('aviso_id')->nullable();

            $table->timestamps();
            
            $table->foreign('operador_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade');
            $table->foreign('aviso_id')->references('id')->on('avisos')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('llamadas');
    }
};