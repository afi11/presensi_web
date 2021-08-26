<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RulePresensi extends Model
{
    protected $table = "rule_presensi";
    protected $fillable = ["id","max_telat_awal","tipe_presensi","status_presensi"];
    public $timestamps = false;
}
