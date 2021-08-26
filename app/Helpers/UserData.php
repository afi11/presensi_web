<?php

use Illuminate\Support\Facades\Session;
use App\User;
use App\Pegawai;
use App\TipePegawai;
use App\Jabatan;

function getUsername()
{
    $user = User::find(Session::get('userid'));
    return $user->username;
}

function cekUserExist()
{
    $userExist = User::where("userid",Session::get('userid'));
    if($userExist->count() == 1){
        return true;
    }else{
        return false;
    }
}

function getTipeAkun()
{
    return Session::get('tipeakun');
}

function getAkunId()
{
    return Session::get('userid');
}

function getDataAkun($pegawaiID)
{
    $user = Pegawai::join('jabatan','jabatan.id','=','pegawai.id_jabatan')
        ->where('pegawai.id_pegawai',$pegawaiID)->first();
    return $user;
}

function getTipePegawai($idtipe, $idjab)
{
    $tipe = TipePegawai::find($idtipe);
    $jabatan = Jabatan::find($idjab);
    return $jabatan->nama_jabatan.' | '.$tipe->nama_tipe;
}

