<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresensisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presensi', function (Blueprint $table) {
            $table->id();
            $table->integer("pegawai_id")->unsigned();
            $table->date("tgl_presensi");
            $table->time("waktu_presensi");
            $table->enum("tipe_presensi",["jam_masuk","jam_pulang"]);
            $table->string("latitude_presensi")->nullable();
            $table->string("longitude_presensi")->nullable();
            $table->double("jarak_presensi")->nullable();
            $table->bigInteger("id_rulepresensi")->unsigned()->nullable();
            $table->enum("tipe_izin",["sakit","izin"])->nullable();
            $table->date("tgl_start_izin")->nullable();
            $table->date("tgl_end_izin")->nullable();
            $table->string("bukti_izin")->nullable();
            $table->bigInteger("lama_izin")->nullable();
            $table->enum("tipe_file",["pdf","image"])->nullable();
            $table->enum("status_izin",["waiting","accepted","rejected"])->nullable();
            $table->mediumText("ket_izin_admin")->nullable();

            $table->foreign("pegawai_id")->references("id_pegawai")->on("pegawai")->onDelete('NO ACTION');
            $table->foreign("id_rulepresensi")->references("id")->on("rule_presensi")->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('presensi');
    }
}
