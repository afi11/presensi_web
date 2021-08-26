<?php

use App\Surattugas;

function getNamaPegawai($surat){
    $pegawai = array();
    $peg = Surattugas::join("pegawai","surattugas.pegawai_id","=","pegawai.id_pegawai")
        ->where("surattugas.no_surat",$surat)->get();
    foreach($peg as $data){
        array_push($pegawai,$data->nama);
    }
    return $pegawai;
}

function getDataPegawaiSurat($surat) {
    $peg = Surattugas::join("pegawai","surattugas.pegawai_id","=","pegawai.id_pegawai")
        ->join('jabatan','jabatan.id','=','pegawai.id_jabatan')
        ->where("surattugas.no_surat",$surat)->get();
    return $peg;
}