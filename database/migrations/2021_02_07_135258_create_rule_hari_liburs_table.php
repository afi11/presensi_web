<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRuleHariLibursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rule_hari_libur', function (Blueprint $table) {
            $table->increments("id_rulelibur");
            $table->date("tanggal");
            $table->bigInteger("id_tipepegawai")->nullable()->unsigned();
            $table->boolean("all_pegawai");

            $table->foreign("id_tipepegawai")->references("id")->on("tipe_pegawai")->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rule_hari_libur');
    }
}
