<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aktivitas extends Model
{
    protected $table = "aktivitas";
    protected $fillable = ["pegawai_id","tanggal","uraian","kuantitas","satuan","file","tipe_file"];
}
