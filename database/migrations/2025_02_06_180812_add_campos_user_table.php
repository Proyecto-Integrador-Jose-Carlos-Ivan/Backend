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
        Schema::table('users', function (Blueprint $table) {
            $table->string('apellidos')->after('name')->nullable();
            $table->string('role')->default('operador');
            $table->string('telefono')->nullable();
            $table->string('lenguas')->nullable();
            $table->date('fecha_contratacion')->nullable();
            $table->date('fecha_baja')->nullable();
            $table->string('username')->unique()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
