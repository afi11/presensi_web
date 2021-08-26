<?php

namespace App\Http\Controllers\Android;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Presensi;
use App\Pegawai;
use App\WaktuPresensi;
use App\RulePresensi;
use App\RuleHariLibur;
use App\DateRecords;
use App\Periode;
use App\Surattugas;

class PresensiController extends Controller
{

    public function __construct(){
        $this->middleware('auth:api');
    }

    public function getTipePegawai($id)
    {
        $tipe = Pegawai::find($id);
        return $tipe->id_tipepeg;
    }


    public function logPresensi(Request $request, $pegawai_id) 
    {
        $tgl_awal = $request->query('tgl_awal');
        $tgl_akhir = $request->query('tgl_akhir');
        if(!empty($tgl_awal) && !empty($tgl_akhir)){
            $data = Presensi::join('rule_presensi','rule_presensi.id','=','presensi.id_rulepresensi')
                ->where('presensi.pegawai_id',$pegawai_id)
                ->whereBetween('presensi.tgl_presensi',array($tgl_awal, $tgl_akhir))
                ->groupBy('presensi.tgl_presensi')
                ->orderBy('presensi.tgl_presensi', 'desc')
                ->select('*','presensi.id as presensi_id')->get();
        }else{
            $data = Presensi::join('rule_presensi','rule_presensi.id','=','presensi.id_rulepresensi')
                ->where('presensi.pegawai_id',$pegawai_id)
                ->groupBy('presensi.tgl_presensi')
                ->orderBy('presensi.tgl_presensi', 'desc')
                ->select('*','presensi.id as presensi_id')->get();
        }
        $presensi = array();
        foreach($data as $row){
            array_push($presensi,[
                "id_presensi" => $row->presensi_id,
                "tgl_presensi" => $row->tgl_presensi,
                "waktu_presensi" => $row->waktu_presensi,
                "tipe_presensi" => $row->tipe_presensi,
                "jam_masuk" => getJamPresensi($row->pegawai_id, $row->tgl_presensi,'jam_masuk'),
                "jam_pulang" => getJamPresensi($row->pegawai_id, $row->tgl_presensi,'jam_pulang'),
                "status_jam_masuk" => getStatusPresensi($row->pegawai_id, $row->tgl_presensi,'jam_masuk'),
                "status_jam_pulang" => getStatusPresensi($row->pegawai_id, $row->tgl_presensi,'jam_pulang')
            ]);
        }
        return response()->json(['data' => $presensi, 'code' => 200]);
    }

    public function getRulePresensi($n_telat, $tipe_presensi)
    {
        $telat = 0;

        if($n_telat == 0){
            $telat = 0;
        }
        else if($n_telat >= 1 && $n_telat <= 30){
            $telat = 30;
        }
        else if($n_telat >= 31 && $n_telat <= 60){
            $telat = 60;
        }
        else if($n_telat >= 61 && $n_telat <= 90 ){
           $telat = 90;
        }else if($n_telat >= 91 ){
            $telat = 91;
        }

        $rule = RulePresensi::where('max_telat_awal',$telat)
            ->where('tipe_presensi',$tipe_presensi)->first();
        return $rule->id;

    }

    public function statistikPresensi(Request $request, $id)
    {
        $awal = $request->query('tgl_awal');
        $akhir = $request->query('tgl_akhir');
        if(!empty($awal) && !empty($akhir)){
            $tgl_awal = $awal;
            $tgl_akhir = $akhir;
        }else{
            $periode = Periode::first();
            $tgl_awal = $periode->periode_awal;
            $tgl_akhir = $periode->periode_akhir;
        }
        $data = array();
        $status = array("TL-1","TL-2","TL-3","TL-4","PSW-1","PSW-2","PSW-3","PSW-4","-","masuk",null,"tm");
        for($i = 0; $i < count($status); $i++){
            array_push($data, [
                "status" => $status[$i],
                "jumlah" => ($status[$i] == "tm"  
                    ? countTidakHadir(
                        $id,
                        $tgl_awal, $tgl_akhir,
                        countRangeStatusPresensi($id, $tgl_awal, $tgl_akhir,'masuk'),
                        countRangeStatusPresensi($id, $tgl_awal, $tgl_akhir,null),
                    )
                    : countRangeStatusPresensi($id, $tgl_awal, $tgl_akhir, $status[$i]))
            ]);
        }
        
        return response()->json(["code" => 200, "data" => $data]);
    }

    public function getPeriode()
    {
        $periode = Periode::first();
        return response()->json(["code" => 200, "data" => $periode]);
    }

    public function presensi(Request $request)
    {
        $tgl = Carbon::now()->format('Y-m-d');

        $cekDate = DateRecords::where("tgl_record",$tgl)->count();
        if($cekDate < 1){
            $date = new DateRecords();
            $date->tgl_record = $tgl;
            $date->save();
        }

        $wkt = Carbon::now()->format('H:i:s');
        $waktu_presensi = $request->waktu_presensi;
        $tipe_presensi = $request->tipe_presensi;
        
        if($tipe_presensi == "jam_masuk"){
            $start = strtotime($waktu_presensi);
            $end = strtotime($wkt);
            $mins = ($end - $start) / 60;
        }else{
            $start = strtotime($waktu_presensi);
            $end = strtotime($wkt);
            $mins = ($start - $end) / 60;
        }


        if($mins < 0){
            $n_telat = 0;
        }else{
            $n_telat = $mins;
        }

        $status_presensi = $this->getRulePresensi($n_telat, $tipe_presensi);

        $presensi = Presensi::create($request->except(['tgl_presensi','waktu_presensi','id_rulepresensi','waktu_presensi','tipe_presensi','n_telat'])
            + [
                'tgl_presensi' => $tgl,
                'waktu_presensi' => $wkt,
                'id_rulepresensi' => $status_presensi,
                'tipe_presensi' => $tipe_presensi,
                'n_telat' => $n_telat
            ]);
        return response()->json(['message' => 'success', 'code' => 200 ]);
    }

    public function showTempat($id)
    {
        $data = Pegawai::join('tempat_presensi','tempat_presensi.id','=','pegawai.id_tempat')
            ->where('pegawai.id_pegawai',$id)->first();
        return response()->json(['data' => $data, 'code' => 200]);
    }

    public function showWaktu($id)
    {
        $namaHari = getNameDay();
        $tipePegawai = $this->getTipePegawai($id); 
        // $data = waktu_presensi::where('hari',$namaHari)
        //     ->where('all_pegawai','1')->first();
        // return response()->json(['data' => $data, 'code' => 200]);

        $waktu = WaktuPresensi::where('hari',$namaHari);
        if($waktu->count() > 0){
            foreach($waktu->get() as $row){
                if($row->all_pegawai == 1){
                    $data = WaktuPresensi::where('hari',$namaHari)
                        ->where('all_pegawai',1)->get();
                    return response()->json(['data' => $data, 'code' => 200]);
                }else{
                    $data = WaktuPresensi::where('hari',$namaHari)
                        ->where('id_tipepegawai',$tipePegawai)->get();
                    return response()->json(['data' => $data, 'code' => 200]);
                }
            }
        }else{
            $data = [];
            return response()->json(['data' => $data, 'code' => 200]);
        }
    }

    public function getLibur()
    {
        $libur = RuleHariLibur::where('tanggal',getTanggal())->first();
        if($libur != null){
            $state = true;
        }else{
            $state = false;
        }
        return response()->json(['data' => $libur, 'islibur' => $state, 'code' => 200]);
    }

    public function cekPresensi($pegawai) {
        $count = Presensi::join("rule_presensi","presensi.id_rulepresensi","=","rule_presensi.id")
            ->where("pegawai_id",$pegawai)
            ->where("tgl_presensi",getTanggal())->count();
        if($count == 2){
            $data = "end";
        }
        else if($count == 1){
            $data = "jam_pulang";
        }else {
            $data = "free";
        }
        // else if($count < 1) {
        //     $data = "free";
        // }
        return response()->json(['data' => $data]);
    }

    public function cekSedangTugas($pegawaiId)
    {
        $statusBerangkat = Surattugas::where('pegawai_id',$pegawaiId)
            ->whereDate('tgl_berangkat','<=',getTanggal())
            ->orderBy('tgl_berangkat', 'desc');
        if($statusBerangkat->count() > 0){
            $tglAwal = $statusBerangkat->first()->tgl_berangkat;
            $tglAkhir = $statusBerangkat->first()->tgl_kembali;
        }else{
            $tglAwal = null;
            $tglAkhir = null;
        }

        $status = cekAdaTugas($pegawaiId);
        return response()->json(["status" => $status, 
            "tgl_berangkat" => $tglAwal,
            "tgl_kembali" => $tglAkhir,
            "code" => 200
        ]);
    }

    public function cekSedangIzin($pegawai)
    {
        $cekIzin = Presensi::where('pegawai_id', $pegawai)
            ->whereDate('tgl_start_izin','<=',getTanggal())
            ->orderBy('tgl_start_izin','desc');
        if($cekIzin->count() > 0){
            $tglAwal = $cekIzin->first()->tgl_start_izin;
            $tglAkhir = $cekIzin->first()->tgl_end_izin;
        }else{
            $tglAwal = null;
            $tglAkhir = null;
        }
        $status = cekAdaIzin($pegawai);
        return response()->json(["status" => $status, 
            "tgl_start" => $tglAwal,
            "tgl_end" => $tglAkhir,
            "code" => 200
        ]);
    }
  
}
