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
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id('pkMovimientos')->autoIncrement();
            $table->dateTime('fechaMovimiento');
            $table->decimal('cantidadMovimiento', 10,2);
            $table->text('descripcion');
            $table->unsignedBigInteger('fkTipoMovimiento');
            $table->unsignedBigInteger('fkUsuario');

            $table->foreign('fkTipoMovimiento')
                ->references('pkTipoMovimiento')
                ->on('tipoMovimiento');

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
        Schema::dropIfExists('movimientos');
    }
};
