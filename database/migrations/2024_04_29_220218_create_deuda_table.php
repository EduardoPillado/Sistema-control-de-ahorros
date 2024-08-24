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
        Schema::create('deuda', function (Blueprint $table) {
            $table->id('pkDeuda')->autoIncrement();
            $table->unsignedBigInteger('fkMovimientos');
            $table->string('nombrePersona', 255);
            $table->decimal('cantidadAbonoRestante', 10,2);
            $table->unsignedBigInteger('fkTipoDeuda');
            $table->unsignedBigInteger('fkCantidadesDeudas');
            $table->smallInteger('estatusDeuda');

            $table->foreign('fkMovimientos')
                ->references('pkMovimientos')
                ->on('movimientos');

            $table->foreign('fkTipoDeuda')
                ->references('pkTipoDeuda')
                ->on('tipoDeuda');

            $table->foreign('fkCantidadesDeudas')
                ->references('pkCantidadesDeudas')
                ->on('cantidadesDeudas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deuda');
    }
};
