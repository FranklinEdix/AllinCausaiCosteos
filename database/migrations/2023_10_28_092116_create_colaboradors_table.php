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
        Schema::create('colaboradors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('last_name');
            $table->integer('dni_carentextrangeria')->unique();
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->decimal('sueldo_hora', 8, 2);
            $table->decimal('sueldo_dia', 8, 2);
            $table->decimal('sueldo_semanal', 8, 2);
            $table->decimal('sueldo_mensual', 8, 2);
            $table->boolean('estado')->default(1);
            $table->bigInteger('id_area');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colaboradors');
    }
};
