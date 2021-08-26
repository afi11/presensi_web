<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DateRecords extends Model
{
    protected $table = "date_records";
    protected $fillable = ["tgl_record"];
    public $timestamps = false;
}
