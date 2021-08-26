<?php

namespace App\Http\Controllers\Android;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\RulePresensi;
use App\WaktuPresensi;
use App\Presensi;
use App\Surattugas;

class DashboardController extends Controller
{

    public function __construct(){
        $this->middleware('auth:api');
    }

    public function getItemDashboard($pegawai_id, $tipe)
    {
        $tgl = Carbon::now()->format("Y-m-d");
        $waktu = WaktuPresensi::where("hari",getNameDay())
            ->where("id_tipepegawai",$tipe)->get();
        $presensi = Presensi::join('rule_presensi','rule_presensi.id','=','presensi.id_rulepresensi')
            ->where("presensi.tgl_presensi",$tgl)
            ->where("presensi.pegawai_id", $pegawai_id)
            ->get();
        $listWaktu = array();
        $listPresensi = array();
        foreach($waktu as $item){
            array_push($listWaktu,[
                "jam_presensi" => $item->jam_presensi,
                "tipe_presensi" => $item->tipe_presensi
            ]);
        }
        foreach($presensi as $item){
            array_push($listPresensi,[
                "status_presensi" => $item->status_presensi,
                "tipe_presensi" => $item->tipe_presensi 
            ]);
        }
        return response()->json(["code" => 200, "waktu" => $listWaktu, "presensi" => $listPresensi]);
    }
    
    public function chartPresensi($pegawai_id)
    {
        $presensi = RulePresensi::groupBy("status_presensi")->get();
        $data = array();
        foreach($presensi as $row){
            array_push($data,[
                "label" => ($row->status_presensi == "-" ? "Tepat Waktu" : $row->status_presensi),
                "data" => countStatusPresensi($pegawai_id, $row->status_presensi),
            ]);
        }
        $label_tambahan = array( "Masuk", "Izin", "Tidak Presensi");
        $data_tambahan = array(countHariMasuk(), countIzinPegawai(), (countHariMasuk() - countIzinPegawai() ) );
        $data2 = array();
        for($i = 0; $i < 3; $i++){
            array_push($data2,[
                "label" => $label_tambahan[$i],
                "data" => $data_tambahan[$i],
            ]);
        }
        $result = array_merge($data, $data2);
        return response()->json(["code" => 200, "data" => $result]);
    }

    public function chartPresensiTipe($pegawai_id, $tipe_presensi)
    {
        $presensiData = Presensi::join('rule_presensi','rule_presensi.id','=','presensi.id_rulepresensi')
            ->join('pegawai','pegawai.id_pegawai','=','presensi.pegawai_id')
            ->first();
        $presensi = RulePresensi::where("tipe_presensi",$tipe_presensi)->get();
        $data = array();
        if($tipe_presensi == "presensi"){
            $label_tambahan = array( "Masuk", "Izin", "Tidak Presensi");
            $data_tambahan = array(
                countPegawaiMasuk($pegawai_id), 
                countIzinPegawaiBy($pegawai_id), 
                ((hitungLamaHari($presensiData->tgl_presensi, getTanggal()) + 1) -  countPegawaiMasuk($pegawai_id) + countIzinPegawaiBy($pegawai_id)) 
            );
            for($i = 0; $i < 3; $i++){
                array_push($data,[
                    "label" => $label_tambahan[$i],
                    "data" => $data_tambahan[$i],
                ]);
            }
        }else{
            foreach($presensi as $row){
                array_push($data,[
                    "label" => ($row->status_presensi == "-" ? "Tepat Waktu" : $row->status_presensi),
                    "data" => countStatusPresensi($pegawai_id, $row->status_presensi),
                ]);
            }
        }
        return response()->json(["code" => 200, "data" => $data]);
    }


    public function chartPenugasanBatalorSelesai($pegawai_id)
    {
        $status = array("batal","selesai","kirim",null);
        $data = array();
        for($i = 0; $i < count($status); $i++){
          array_push($data, [
            "label" => ($status[$i] == null ? 'proses' : $status[$i]),
            "data" => countStatusTugas($pegawai_id, $status[$i])
          ]);
        }
        return response()->json(["code" => 200, "data" => $data]);
    }

}
