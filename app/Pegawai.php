<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = "pegawai";
    protected $primaryKey = "id_pegawai";
    protected $fillable = ["userid","nip","nama","alamat","foto","id_jabatan",
        "id_tipepeg","id_tempat","telepon","pangkat","golongan"];
    public $timestamps = false;
}
