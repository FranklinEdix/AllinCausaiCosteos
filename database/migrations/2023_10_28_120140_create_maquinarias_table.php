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
        Schema::create('maquinarias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->decimal('precio_consumo_hora', 8, 2)->nullable();
            $table->decimal('precio_consumo_mensual', 8, 2)->nullable();
            $table->string('modelo')->nullable();
            $table->string('marca')->nullable();
            $table->string('serie')->nullable();
            $table->string('placa')->nullable();
            $table->string('color')->nullable();
            $table->string('descripcion')->nullable();
            $table->string('mantenimiento')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maquinarias');
    }
};
