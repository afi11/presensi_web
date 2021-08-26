<?php

use App\Aktivitas;

function countAktivitas($tgl){
    $count = Aktivitas::where('tanggal',$tgl)->count();
    return $count;
}