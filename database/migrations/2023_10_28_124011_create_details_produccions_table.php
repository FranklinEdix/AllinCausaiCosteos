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
        Schema::create('details_produccions', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_proceso');
            $table->string('nombre_proceso');
            $table->string('produccion_id');
            $table->string('insumo_id');
            $table->string('maquinaria_id');
            $table->string('colaborador_id');
            $table->decimal('gasto_total_insumos', 8, 2);
            $table->decimal('gasto_total_maquinarias', 8, 2);
            $table->decimal('gasto_total_colaboradores', 8, 2);
            $table->text('data_tiempos_procedimiento')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('details_produccions');
    }
};
