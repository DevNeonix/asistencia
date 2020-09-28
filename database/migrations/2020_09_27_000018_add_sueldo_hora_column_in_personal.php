<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSueldoHoraColumnInPersonal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('personal', function (Blueprint $table) {
            $table->double("remuneracion")->nullable()->default(0);
            $table->double("costo_hora")->nullable()->default(0);
            $table->double("costo_hora_25")->nullable()->default(0);
            $table->double("costo_hora_35")->nullable()->default(0);
            $table->double("costo_hora_100")->nullable()->default(0);
            $table->double("asignacion_familiar")->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('personal', function (Blueprint $table) {
            $table->dropColumn("remuneracion");
            $table->dropColumn("costo_hora");
            $table->dropColumn("costo_hora_25");
            $table->dropColumn("costo_hora_35");
            $table->dropColumn("costo_hora_100");
        });
    }
}
