<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCentroCostoIdColumnInOrdenTrabajo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orden_trabajo', function (Blueprint $table) {
            $table->unsignedBigInteger('centro_costo_id')->nullable();
            $table->foreign('centro_costo_id')->references('id')->on('centro_costos');
            $table->double('viatico')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orden_trabajo', function (Blueprint $table) {
            $table->dropColumn('centro_costo_id');
            $table->dropColumn('viatico');
        });
    }
}
