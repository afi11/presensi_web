<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Surattugas extends Model
{
    protected $table = "surattugas";
    protected $fillable = ["pegawai_id","no_surat","tgl_berangkat","tgl_kembali","perihal","tempat_tugas",
        "jenis_angkutan","jenis_tugas","file","status","keterangan","tipe_file","bukti_file","menimbang","dasar","atas_nama","tembusan"];
    public $timestamps = false;
}
