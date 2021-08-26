<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TempatPresensi extends Model
{
    protected $table = "tempat_presensi";
    protected $fillable = ["nama_tempat","alamat","latitude_tempat","longitude_tempat"];
    public $timestamps = false;
}
