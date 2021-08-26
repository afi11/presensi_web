<?php

namespace App\Http\Controllers\Android;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Aktivitas;

class AktivitasController extends Controller
{
    
    public function __construct(){
        $this->middleware('auth:api');
    }

    public function logAktivitas(Request $request,$pegawaiId)
    {
        $bulan = $request->query('bulan');
        $tahun = $request->query('tahun');
        if($bulan != 0 && $tahun != 0){
            $aktivitas = Aktivitas::join('pegawai','pegawai.id_pegawai','aktivitas.pegawai_id')
                ->where('aktivitas.pegawai_id',$pegawaiId)
                ->whereMonth('aktivitas.tanggal',$bulan)
                ->whereYear('aktivitas.tanggal',$tahun)
                ->get();
        }else{
            $aktivitas = Aktivitas::join('pegawai','pegawai.id_pegawai','aktivitas.pegawai_id')
                ->where('aktivitas.pegawai_id',$pegawaiId)
                ->get();
        }
        return response()->json(['data' => $aktivitas, 'code' => 200]);
    }
    
    public function store(Request $request)
    {
        $tgl = Carbon::now()->format('Y-m-d');
        if(empty($request->file)){
            $tipeFile = null;
            $fileName = null;
        }else{
            $tipeFile = $request->tipefile;
            $tipe = "";
            if($tipeFile == "pdf"){
                $tipe = ".pdf";
            }else{
                $tipe = ".jpg";
            }
            $fileName = Carbon::now()->format('Y-m-d').'-'.\Illuminate\Support\Str::random(10).$tipe;
            $path = public_path().'/files/aktivitas/';
            file_put_contents($path.$fileName,base64_decode($request->file));
        }
        $aktivitas = Aktivitas::create(
            $request->except(["tanggal","file","tipe_file"])+[
                "tanggal" => $tgl,
                "file" => $fileName,
                "tipe_file" => $tipe
            ]);
        return response()->json(['message' => 'success', 'code' => 200 ]);
    }

}
