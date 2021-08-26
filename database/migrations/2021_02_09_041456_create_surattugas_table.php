<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurattugasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surattugas', function (Blueprint $table) {
            $table->id();
            $table->integer("pegawai_id")->unsigned();
            $table->string('no_surat');
            $table->date('tgl_berangkat');
            $table->date('tgl_kembali');
            $table->string('perihal');
            $table->string('tempat_tugas');
            $table->string('jenis_angkutan');
            $table->string('jenis_tugas');
            $table->string('file');

            $table->foreign("pegawai_id")->references("id_pegawai")->on("pegawai")->onDelete('NO ACTION');
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
        Schema::dropIfExists('surattugas');
    }
}
