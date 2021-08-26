<?php

use App\Presensi;
use App\Surattugas;

function getJamPresensi($pegawai, $tgl, $tipe){
    $data = Presensi::where('pegawai_id',$pegawai)
        ->where('tgl_presensi',$tgl)
        ->where('tipe_presensi',$tipe)
        ->get();
    foreach($data as $row){
        $waktu = $row->waktu_presensi;
        return $waktu;
    }
}

function getStatusPresensi($pegawai, $tgl, $tipe){
    $data = Presensi::join('rule_presensi','rule_presensi.id','=','presensi.id_rulepresensi')
        ->where('presensi.pegawai_id',$pegawai)
        ->where('presensi.tgl_presensi',$tgl)
        ->where('presensi.tipe_presensi',$tipe)
        ->get();
        foreach($data as $row){
            $rule = $row->status_presensi;
            return $rule;
        }
}

function countLate($pegawai, $tgl, $tipe)
{
    $data = Presensi::where('pegawai_id',$pegawai)
        ->where('tgl_presensi',$tgl)
        ->where('tipe_presensi',$tipe)
        ->first();
    return ($data->n_telat == null ? "-" : $data->n_telat);
}

function countHariMasuk($tglAwal, $tglAkhir)
{
    $presensi = Presensi::join('rule_presensi','rule_presensi.id','=','presensi.id_rulepresensi')
        ->whereBetween('presensi.tgl_presensi',array($tglAwal, $tglAkhir))
        ->groupBy('presensi.tgl_presensi')
        ->get();
    $totalData = 0;
    foreach($presensi as $row){
        $totalData = $totalData + 1;
    }
    return $totalData;
}

function countIzinPegawai($tglAwal, $tglAkhir)
{
    $izin = Presensi::where('presensi.tipe_izin','<>',null)
        ->whereBetween('presensi.tgl_presensi',array($tglAwal, $tglAkhir))
        ->get();
    $lamaIzin = 0;
    foreach($izin as $row){
        $lamaIzin = $lamaIzin + (hitungLamaHari($row->tgl_start_izin, $row->tgl_end_izin) + 1);
    }
    return $lamaIzin;
}

function countRangeStatusPresensi($pegawai, $tglAwal, $tglAkhir, $tipe)
{
    if($tipe == null){
        $status = "accepted";
        $izin = Presensi::where('presensi.pegawai_id',$pegawai)
            ->where('presensi.tipe_izin','<>',null)
            ->where('presensi.status_izin',$status)
            ->whereBetween('presensi.tgl_presensi',array($tglAwal, $tglAkhir))
            ->get();
        $lamaIzin = 0;
        foreach($izin as $row){
            $lamaIzin = $lamaIzin + (hitungLamaHari($row->tgl_start_izin, $row->tgl_end_izin) + 1);
        }
        $data = $lamaIzin;
    }else if($tipe == 'masuk'){
        $presensi = Presensi::join('rule_presensi','rule_presensi.id','=','presensi.id_rulepresensi')
            ->where('presensi.pegawai_id',$pegawai)
            ->whereBetween('presensi.tgl_presensi',array($tglAwal, $tglAkhir))
            ->groupBy('presensi.tgl_presensi')
            ->get();
        $totalData = 0;
        foreach($presensi as $row){
            $totalData = $totalData + 1;
        }
        $data = $totalData;
    }
    else if($tglAwal == "" && $tglAkhir == ""){
        $data = Presensi::join('rule_presensi','rule_presensi.id','=','presensi.id_rulepresensi')
            ->where('presensi.pegawai_id',$pegawai)
            ->groupBy('presensi.tgl_presensi')
            ->where('rule_presensi.status_presensi',$tipe)
            ->count();
    }
    else{
        $data = Presensi::join('rule_presensi','rule_presensi.id','=','presensi.id_rulepresensi')
            ->where('presensi.pegawai_id',$pegawai)
            ->whereBetween('presensi.tgl_presensi',array($tglAwal, $tglAkhir))
            ->where('rule_presensi.status_presensi',$tipe)
            ->count();
    }
    return $data;
}

function countStatusPresensi($pegawai, $tipe)
{
    $data = Presensi::join('rule_presensi','rule_presensi.id','=','presensi.id_rulepresensi')
            ->where('presensi.pegawai_id',$pegawai)
            ->where('rule_presensi.status_presensi',$tipe)
            ->count();
    return $data;
}

function countTidakHadir($pegawai, $tglAwal, $tglAkhir, $izin, $hadir)
{
    $tgl1 = new \DateTime($tglAwal);
    $tgl2 = new \DateTime($tglAkhir);
    $day = $tgl1->diff($tgl2);
    return ($day->format('%a') + 1) - $izin - $hadir;
}

function getTglIzinBerakhir($pegawai){
    $count = Presensi::where('pegawai_id',$pegawai)
        ->where('status_izin','accepted')
        ->orderBy('tgl_end_izin','desc')->count();
    if($count > 0){
        $presensi = Presensi::where('pegawai_id',$pegawai)
        ->where('status_izin','accepted')
        ->orderBy('tgl_end_izin','desc')->first();
        return $presensi->tgl_end_izin;   
    }else{
        return null;
    }
}

function countPegawaiMasuk($pegawai)
{
    $presensi = Presensi::join('rule_presensi','rule_presensi.id','=','presensi.id_rulepresensi')
        ->where('presensi.pegawai_id',$pegawai)
        ->groupBy('presensi.tgl_presensi')
        ->first();
    $data = Presensi::join('rule_presensi','rule_presensi.id','=','presensi.id_rulepresensi')
        ->where('presensi.pegawai_id',$pegawai)
        ->whereBetween('presensi.tgl_presensi',array($presensi->tgl_presensi, getTanggal()))
        ->groupBy('presensi.tgl_presensi')
        ->get();
    $hari = 0;
    foreach($data as $row){
        $hari = $hari + 1;
    }
    return $hari;
}

function countIzinPegawaiBy($pegawai)
{
    $tglAwal = Presensi::where('pegawai_id',$pegawai)->first();
    $tglAkhir = Presensi::where('pegawai_id',$pegawai)->orderBy('id','desc')->first();
    $izin = Presensi::where('presensi.pegawai_id',$pegawai)
        ->where('presensi.tipe_izin','<>',null)
        ->whereBetween('presensi.tgl_presensi',array($tglAwal->tgl_presensi, getTanggal()))
        ->where('presensi.status_izin','accepted')
        ->get();
    $lamaIzin = 0;
    foreach($izin as $row){
        $lamaIzin = $lamaIzin + (hitungLamaHari($row->tgl_start_izin, $row->tgl_end_izin) + 1);
    }
    return $lamaIzin;
}

function cekAdaTugas($pegawai){
    $cekTugasSekarang = Surattugas::where('pegawai_id',$pegawai)
        ->whereDate('tgl_berangkat',getTanggal())
        ->count();
    $statusBerangkat = Surattugas::where('pegawai_id',$pegawai)
        ->whereDate('tgl_berangkat','<=',getTanggal())
        ->orderBy('tgl_berangkat', 'desc');
        
    if($cekTugasSekarang > 0){
        return true;
    }else if($statusBerangkat->count() > 0){
        if(hitungTanggalNegatif(getTanggal(),$statusBerangkat->first()->tgl_kembali) <= 0){
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}

function cekAdaIzin($pegawai){
    $cekIzinSekarang = Presensi::where('pegawai_id', $pegawai)
        ->whereDate('tgl_start_izin',getTanggal())
        ->count();
    $cekIzin = Presensi::where('pegawai_id', $pegawai)
        ->whereDate('tgl_start_izin','<=',getTanggal())
        ->orderBy('tgl_start_izin','desc');
    if($cekIzinSekarang > 0){
        return true;
    }else if($cekIzin->count() > 0){
        if(hitungTanggalNegatif(getTanggal(),$cekIzin->first()->tgl_end_izin) <= 0){
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}
