<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRulePresensisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rule_presensi', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("max_telat_awal");
            $table->enum("tipe_presensi",["jam_masuk","jam_pulang"]);
            $table->string("status_presensi",100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rule_presensi');
    }
}
