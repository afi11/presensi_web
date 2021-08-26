<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WaktuPresensi extends Model
{
    protected $table = "waktu_presensi";
    protected $primaryKey = "id_waktu";
    protected $fillable = ["hari","jam_presensi","tipe_presensi","id_tipepegawai","all_pegawai"];
    public $timestamps = false;
}
