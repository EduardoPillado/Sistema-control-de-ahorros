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
        Schema::create('ahorro', function (Blueprint $table) {
            $table->id('pkAhorro')->autoIncrement();
            $table->decimal('cantidadAhorro', 10,2);
            $table->dateTime('fechaIngreso');
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
        Schema::dropIfExists('ahorro');
    }
};
