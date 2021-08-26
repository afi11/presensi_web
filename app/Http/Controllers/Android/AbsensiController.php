<?php

namespace App\Http\Controllers\Android;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Presensi;
use App\Pegawai;
use App\WaktuPresensi;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
        $this->middleware('auth:api');
    }

    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function logAbsensi(Request $request, $pegawai_id) 
    {
        $tgl_awal = $request->query('tgl_awal');
        $tgl_akhir = $request->query('tgl_akhir');
        if(!empty($tgl_awal) && !empty($tgl_akhir)){
            $data = Presensi::where('presensi.tipe_izin','<>',null)
                ->where('presensi.pegawai_id',$pegawai_id)
                ->whereBetween('presensi.tgl_start_izin',array($tgl_awal, $tgl_akhir))
                ->orWhereBetween('presensi.tgl_end_izin',array($tgl_awal, $tgl_akhir))
                ->orderBy('presensi.tgl_presensi', 'desc')
                ->select('*','presensi.id as presensi_id')->get();
        }else{
            $data = Presensi::where('presensi.tipe_izin','<>',null)
                ->where('presensi.pegawai_id',$pegawai_id)
                ->orderBy('presensi.tgl_presensi', 'desc')
                ->select('*','presensi.id as presensi_id')->get();
        }
        $presensi = array();
        foreach($data as $row){
            array_push($presensi,[
                "id_presensi" => $row->presensi_id,
                "tgl_presensi" => $row->tgl_presensi,
                "tipe_izin" => $row->tipe_izin,
                "bukti_izin" => $row->bukti_izin,
                "tgl_start_izin" => $row->tgl_start_izin,
                "tgl_end_izin" => $row->tgl_end_izin,
                "status_izin" => $row->status_izin,
                "ket_from_admin" => ($row->ket_izin_admin == null ? "-" : $row->ket_izin_admin),
                "lama_izin" => hitungLamaHari($row->tgl_start_izin, $row->tgl_end_izin),
                "tipe_file" => $row->tipe_file,
                "keterangan" => $row->keterangan
            ]);
        }
        return response()->json(['data' => $presensi, 'code' => 200]);
    }

    public function store(Request $request)
    {
        $tglEndIzin = getTglIzinBerakhir($request->pegawai_id);
                $lamaHari = hitungLamaHari($request->tgl_start_izin, $request->tgl_end_izin);
                $tipeIzin = $request->tipeIzin;
                if($tipeIzin == "Sakit"){
                    $alasan = "sakit";
                    $status = "waiting";
                }else if($tipeIzin == "Dinas Luar"){
                    $alasan = "dinas_luar";
                    $status = "accepted";
                }else{
                    $alasan = "lainnya";
                    $status = "waiting";
                }
    
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
                    $path = public_path().'/files/absensi/';
                    file_put_contents($path.$fileName,base64_decode($request->file));
                }
                $tgl = Carbon::now()->format('Y-m-d');
                $waktu = Carbon::now()->format('H:i:s');   
                
        if($tglEndIzin != null){
            $dayLong = hitungTanggalNegatif($request->tgl_start_izin, $tglEndIzin);
            if($dayLong >= 0){
                $absensi = Presensi::create(
                    $request->except(['tgl_presensi','waktu_presensi','bukti_izin','tipe_file','tipe_izin','status_izin'])+[
                        'tgl_presensi' => $tgl,
                        'waktu_presensi' => $waktu,
                        'bukti_izin' => $fileName,
                        'tipe_file' => $tipeFile,
                        'tipe_izin' => $alasan,
                        'status_izin' => $status
                    ]);
                return response()->json(['message' =>  "success", 'code' => 200]);
            }else {
                return response()->json(['message' =>  "Anda masih dalam masa cuti yang berakhir pada tanggal ".$tglEndIzin." silahkan ajukan setelah tanggal tersebut", 'code' => 201]);
            }
        }else{
            $absensi = Presensi::create(
                    $request->except(['tgl_presensi','waktu_presensi','bukti_izin','tipe_file','tipe_izin','status_izin'])+[
                        'tgl_presensi' => $tgl,
                        'waktu_presensi' => $waktu,
                        'bukti_izin' => $fileName,
                        'tipe_file' => $tipeFile,
                        'tipe_izin' => $alasan,
                        'status_izin' => $status
                    ]);
                return response()->json(['message' =>  "success", 'code' => 200]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $oldFile = $request->old_file;
        $lamaHari = hitungLamaHari($request->tgl_start_izin, $request->tgl_end_izin);
        $tipeIzin = $request->tipeIzin;
        if($tipeIzin == "Sakit"){
            $alasan = "sakit";
        }else if($tipeIzin == "Dinas Luar"){
            $alasan = "dinas_luar";
        }else{
            $alasan = "lainnya";
        }
       
        $absensi = Presensi::find($id);
        if(empty($request->file)){
            $tipeFile = null;
            $fileName = null;
        }else{
            \File::delete(public_path('files/absensi/'.$oldFile));
            $tipeFile = $request->tipefile;
            $tipe = "";
            if($tipeFile == "pdf"){
                $tipe = ".pdf";
            }else{
                $tipe = ".jpg";
            }
            $fileName = Carbon::now()->format('Y-m-d').'-'.\Illuminate\Support\Str::random(10).$tipe;
            $path = public_path().'/files/absensi/';
            file_put_contents($path.$fileName,base64_decode($request->file));

            $absensi->tipe_file = $tipeFile;
            $absensi->bukti_izin =  $fileName;
        };

        $absensi->tgl_start_izin = $request->tgl_start_izin;
        $absensi->tgl_end_izin = $request->tgl_end_izin;
        $absensi->tipe_izin = $alasan;
        $absensi->keterangan = $request->keterangan;
        $absensi->save();
        return response()->json(['message' => 'Berhasil mengubah izin', 'code' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
