<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipePegawai extends Model
{
    protected $table = "tipe_pegawai";
    protected $fillable = ["nama_tipe"];
    public $timestamps = false;
}
