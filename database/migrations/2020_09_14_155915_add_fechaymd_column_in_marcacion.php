<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFechaymdColumnInMarcacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('marcacion', function (Blueprint $table) {
            $table->date('fechaymd')->nullable()->default(DB::raw('(current_date)'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('marcacion', function (Blueprint $table) {
            $table->dropColumn('fechaymd');
        });
    }
}
