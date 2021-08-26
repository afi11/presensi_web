<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    protected $table = "periode";
    protected $fillable = ["periode_awal","periode_akhir"];
    public $timestamps = false;
}
