<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarcacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marcacion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personal')->references('id')->on('orden_trabajo');
            $table->foreignId('orden_trabajo')->references('id')->on('personal');
            $table->dateTime('fecha');
            $table->integer('usuario_registra');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marcacion');
    }
}
