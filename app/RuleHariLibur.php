<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RuleHariLibur extends Model
{
    protected $table = "rule_hari_libur";
    protected $primaryKey = "id_rulelibur";
    protected $fillable = ["tanggal","id_tipepegawai","all_pegawai","keterangan"];
    public $timestamps = false;
}
