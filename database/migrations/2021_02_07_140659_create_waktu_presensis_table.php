<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaktuPresensisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waktu_presensi', function (Blueprint $table) {
            $table->increments("id_waktu");
            $table->string("hari",20);
            $table->time("jam_presensi");
            $table->enum("tipe_presensi",["jam_masuk","jam_pulang"]);
            $table->bigInteger("id_tipepegawai")->nullable()->unsigned();

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
        Schema::dropIfExists('waktu_presensi');
    }
}
