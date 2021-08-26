<?php

function GetWaktuPresensi($tipe_pegawai) {
    $exactTime = array();
    $waktu = \App\WaktuPresensi::where('hari',getNameDay())->get();
    $waktuTipe = array();
    foreach($waktu as $data){
        if($data->id_tipepegawai == $tipe_pegawai){
            array_push($waktuTipe, $data);
        }
    }
    $allWaktu = array();
    foreach($waktu as $data){
        if($data->all_pegawai == '1'){
            array_push($allWaktu, $data);
        }
    }

    if(count($waktuTipe) > 0){
        $exactTime = $waktuTipe;
    }
    else if(count($allWaktu) > 0){
        $exactTime = $allWaktu;
    }
    return $exactTime;
    //return json_encode($waktu);
}