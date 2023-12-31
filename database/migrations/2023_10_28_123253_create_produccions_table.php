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
        Schema::create('produccions', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('presentacion')->nullable();
            $table->string('descripcion');
            $table->string('producto_final');
            $table->integer('cantidad_producto_final');
            $table->decimal('gasto_total', 8, 2)->default(0.00);
            $table->decimal('precio_total', 8, 2)->default(0.00);
            $table->integer('estado')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produccions');
    }
};
