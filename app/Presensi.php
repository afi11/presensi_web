<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    protected $table = "presensi";
    protected $fillable = ["pegawai_id","tgl_presensi","waktu_presensi","tipe_presensi",
        "latitude_presensi","longitude_presensi","jarak_presensi","id_rulepresensi",
        "tipe_izin", "tgl_start_izin","tgl_end_izin","bukti_izin","tipe_file","n_telat","keterangan","status_izin",
        "ket_izin_admin"
    ];
    public $timestamps = false;
}
