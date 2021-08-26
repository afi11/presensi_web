<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempatPresensisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tempat_presensi', function (Blueprint $table) {
            $table->id();
            $table->mediumText("nama_tempat");
            $table->mediumText("alamat");
            $table->string("latitude_tempat");
            $table->string("longitude_tempat");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tempat_presensi');
    }
}
