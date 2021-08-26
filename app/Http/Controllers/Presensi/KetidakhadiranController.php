<?php

namespace App\Http\Controllers\Presensi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Presensi;
use App\Pegawai;
use App\TipePegawai;
use Carbon\Carbon;
use PDF;
use LynX39\LaraPdfMerger\Facades\PdfMerger;

class KetidakhadiranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Daftar Ketidakhadiran Pegawai";
        $tipe = TipePegawai::all();
        return view('presensi.ketidakhadiran.index',compact('title','tipe'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page = "create";
        $title = "Tambah Ketidakhadiran Pegawai";
        $pegawai = Pegawai::all();
        return view("presensi.ketidakhadiran.create_edit",compact("page","title","pegawai"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $presensi = Presensi::where('id',$request->presensi_id)
            ->update([
                'status_izin' => $request->status_izin,
                'ket_izin_admin' => $request->ket_izin_admin
            ]);
        $this->sendNotification($request->pegawai_id, $request->status_izin, $request->tgl_awal, $request->tgl_akhir, $request->ket_izin_admin);
        return redirect()->back()->with('success','Berhasil Memperbaruhi perizinan');
    }

    public function addIzin(Request $request)
    {
        $tgl = Carbon::now()->format('Y-m-d');
        $waktu = Carbon::now()->format('H:i:s');
        $resource = $request->file('bukti_izin');
        
        $tipeFile = $resource->getClientOriginalExtension();
        $fileName = Carbon::now()->format('Y-m-d').'-'.\Illuminate\Support\Str::random(10).'.'.$tipeFile;

        $resource->move(\base_path() ."/public/files/absensi", $fileName);

        $absensi = Presensi::create(
            $request->except(['tgl_presensi','waktu_presensi','bukti_izin','tipe_file','tipe_izin','status_izin','ket_izin_admin'])+[
                'tgl_presensi' => $tgl,
                'waktu_presensi' => $waktu,
                'bukti_izin' => $fileName,
                'tipe_file' => $tipeFile,
                'status_izin' => "accepted"
            ]);
        return redirect('ketidakhadiran')->with('success','Berhasil Menambah Izin Pegawai');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = "Daftar Ketidakhadiran Pegawai";
        $absensi = Presensi::join('pegawai','presensi.pegawai_id','=','pegawai.id_pegawai')
            ->join('jabatan','jabatan.id','=','id_jabatan')
            ->join('tipe_pegawai','tipe_pegawai.id','=','pegawai.id_tipepeg')
            ->where('presensi.tipe_izin','<>',null)
            ->where('pegawai.id_tipepeg',$id)
            ->select('presensi.id as presensi_id','presensi.*','presensi.id as presensi_id','jabatan.*','tipe_pegawai.*','pegawai.*')
            ->orderBy('presensi.status_izin','desc')
            ->get();
        return view('presensi.ketidakhadiran.show',compact('absensi','title'));
    }

    public function cetakPengajuanCutiIzin($presensiId, $idPegawai)
    {
        $pegawai = Pegawai::join('jabatan','jabatan.id','=','pegawai.id_jabatan')
            ->where('pegawai.id_pegawai',$idPegawai)
            ->first();
        $presensi = Presensi::find($presensiId);
        $tgl = Carbon::now()->format('Y-m-d');
        $pdf = PDF::loadView('presensi.ketidakhadiran.cetak_pegajuan',
            ['pegawai' => $pegawai, 'presensi' => $presensi, 'tgl' => $tgl])
            ->setPaper('a4');
        if($presensi->tipe_file == "image"){
            return $pdf->download('Pengajuan_Izin_'.$pegawai->nama.'.pdf');
        }else{
            $fileName = 'Pengajuan_Izin_'.$pegawai->nama.'.pdf';
            $pdf->save('files/pengajuan/'.$fileName);
            $pdfMerger = PDFMerger::init(); 
            $pdfMerger->addPDF(public_path('files/pengajuan/'.$fileName),'all');
            $pdfMerger->addPDF(public_path('files/absensi/'.$presensi->bukti_izin),'all');
            $pdfMerger->merge();
            $pdfMerger->save(public_path('files/pengajuan/srt_pengajuan.pdf'),"download");

        }
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
        //
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

    public function sendNotification($idPegawai, $status, $tglAwal, $tglAkhir, $ket)
    {
        // $notif = new SendFcmNotif();
        // $this->dispatch($notif);
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $token = "AAAA8ebM3Q4:APA91bGAAWqa0LIQbZE-SsGZVx6MueJ32LafTle6nR6TEN91sBX8vnnQsqC6ym1M_B3XLSsG1tZtdNQ1U0WSoTnW-kBxxtzi0RwsWYsPToHppMuNThBUJaBPwz0CnXGE4klI7HTCnnIr";

        $notification = [
            'tipeNotifikasi' => "pengajuan_cuti",
            'pegawaiId' => $idPegawai,
            'status' => $status,
            'tglAwal' => $tglAwal,
            'tglAkhir' => $tglAkhir,
            'ket' => $ket
        ];

        // $notificationData = ["message" => $notification,"moredata" =>'dd'];

        $fcmNotification = [
            //'registration_ids' => $tokenList, 
            'to' => "/topics/PresensiNotification",
            'data' => $notification
        ];

        $headers = [
            'Content-Type: application/json',
            'Authorization: key='.$token,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $response = curl_exec($ch);
        curl_close($ch);
        return response()->json($response);
    }

}
