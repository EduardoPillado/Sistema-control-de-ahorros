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
        Schema::create('cantidadesDeudas', function (Blueprint $table) {
            $table->id('pkCantidadesDeudas')->autoIncrement();
            $table->decimal('cantidadDeudasUsuario', 10,2)->nullable();
            $table->decimal('cantidadDeudasOtros', 10,2)->nullable();
            $table->unsignedBigInteger('fkUsuario');

            $table->foreign('fkUsuario')
                ->references('pkUsuario')
                ->on('usuario');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cantidadesDeudas');
    }
};
