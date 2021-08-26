<?php

namespace App\Http\Controllers\Android;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Surattugas;
use Carbon\Carbon;

class SuratController extends Controller
{

    public function __construct(){
        $this->middleware('auth:api');
    }
    
    public function getLog(Request $request, $idpegawai){
        $bulan = $request->query('bulan');
        $tahun = $request->query('tahun');
        if($bulan != 0 && $tahun != 0){
            $tugas = Surattugas::whereMonth('tgl_kembali',$bulan)
                ->whereYear('tgl_kembali',$tahun)
                ->where("pegawai_id",$idpegawai)
                ->orderBy('tgl_berangkat','desc')
                ->get();
        }else{
            $tugas = Surattugas::where("pegawai_id",$idpegawai)
                ->orderBy('tgl_berangkat','desc')
                ->get();
        }
        return response()->json(["code" => 200, "data" => $tugas]);
    }

    public function update(Request $request, $id)
    {
        $tipeFile = $request->tipefile;
        $tipe = "";
        if($tipeFile == "pdf"){
            $tipe = ".pdf";
        }else if($tipeFile == "doc"){
            $tipe = ".docx";
        }else{
            $tipe = ".jpg";
        }
        $fileName = Carbon::now()->format('Y-m-d').'-'.\Illuminate\Support\Str::random(10).$tipe;
        $path = public_path().'/files/tugas/';
        file_put_contents($path.$fileName,base64_decode($request->file));
        
        $tugas = Surattugas::find($id);
        $tugas->tipe_file = $tipeFile;
        $tugas->bukti_file = $fileName;
        $tugas->status = "selesai";
        $tugas->keterangan = "Selesai dilaksanakan";
        $tugas->save();
        return response()->json(['message' => 'success', 'code' => 200 ]);
    }

}
