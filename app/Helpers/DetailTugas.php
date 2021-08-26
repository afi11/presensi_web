<?php

use App\Surattugas;

function countStatusTugas($idPegawai, $status)
{
    if($idPegawai == null){
       $data = Surattugas::where('status',$status)
                ->groupBy('no_surat')
                ->get();
       $count = 0;
       foreach($data as $row){
        $count++;
       }
    }else{
        $count = Surattugas::where('pegawai_id',$idPegawai)
            ->where('status',$status)
            ->count();
    }
    return $count;
}
function listPegawai($no_surat)
{
    $data = DB::table('surattugas')->join('pegawai', 'pegawai.id_pegawai', '=', 'surattugas.pegawai_id')
        ->where('surattugas.no_surat', $no_surat)
        ->select('surattugas.*', 'pegawai.*')->get();
    return $data;
}