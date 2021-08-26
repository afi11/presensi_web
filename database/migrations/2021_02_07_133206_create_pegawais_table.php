<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePegawaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawai', function (Blueprint $table) {
            $table->increments("id_pegawai");
            $table->string("userid");
            $table->string("nip",100);
            $table->string("nama");
            $table->mediumText("alamat");
            $table->string("foto")->default("default.jpg");
            $table->bigInteger("id_jabatan")->unsigned();
            $table->string("pangkat",50)->nullable();
            $table->string("golongan",50)->nullable();
            $table->bigInteger("id_tipepeg")->unsigned();
            $table->bigInteger("id_tempat")->unsigned();
            $table->string("telepon",20)->nullable();

            $table->foreign("userid")->references("userid")->on("akun")->onDelete('NO ACTION');
            $table->foreign("id_jabatan")->references("id")->on("jabatan")->onDelete('NO ACTION');
            $table->foreign("id_tipepeg")->references("id")->on("tipe_pegawai")->onDelete('NO ACTION');
            $table->foreign("id_tempat")->references("id")->on("tempat_presensi")->onDelete('NO ACTION'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pegawai');
    }
}
