<?php

namespace App\Http\Controllers\Penugasan;

use App\Http\Controllers\Controller;
use App\Pegawai;
use App\Surattugas;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\ExportExcel\TugasExport;

class TugasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penugasan = Surattugas::orderBy('tgl_berangkat','desc')->get()->unique('no_surat');
        return view("penugasan.tugas.index",compact("penugasan"));
    }

    public function rekap(Request $request)
    {
        $tahun = $request->tahun;
        $bulan = $request->bulan;
        $penugasan = Surattugas::whereMonth('tgl_kembali',$bulan)
            ->whereYear('tgl_kembali',$tahun)
            ->get()
            ->unique('no_surat');
        return view("penugasan.tugas.rekap",compact("penugasan"));
    }

    public function cetakPdf(Request $request)
    {
        $tahun = $request->tahun;
        $bulan = $request->bulan;
        if($tahun == "" && $bulan == ""){
            $penugasan = Surattugas::all()
                ->unique('no_surat');
        }else{
            $penugasan = Surattugas::whereMonth('tgl_kembali',$bulan)
                ->whereYear('tgl_kembali',$tahun)
                ->get()
                ->unique('no_surat');
        }
        $pdf = PDF::loadView('penugasan.tugas.rekap.tugas_pdf',
                ['penugasan' => $penugasan, 'bulan' => $bulan, 'tahun' => $tahun])
                ->setPaper('a4');
        return $pdf->download('Rekap_Penugasan_Bulan_'.$bulan.'_Tahun_'.$tahun.'.pdf');
    }

    public function export_excel(Request $request)
	{
        $tahun = $request->tahun;
        $bulan = $request->bulan;
		return Excel::download(new TugasExport($bulan, $tahun), 'Data_Penugasan_'.'.xlsx');
	}

    public function validation($request)
    {
        $validate_data = $this->validate(
            $request,
            [
                'nama_jabatan' => 'required',
                'tgl_berangkat' => 'required',
                'tgl_kembali' => 'required',
                'no_surat' => 'required',
                'perihal' => 'required',
                'tempat_tugas' => 'required',
                'pegawai_id' => 'required',
                'jenis_angkutan' => 'required',
                'jenis_tugas' => 'required',
                'file' => 'required',
            ],
            [
                'nama_jabatan.required' => 'Nama jabatan harus diisi',
                'tgl_berangkat.required' => 'Tanggal Berangkat harus diisi',
                'tgl_kembali.required' => 'Tanggal Kembali harus diisi',
                'no_surat.required' => 'Nomor Surat harus diisi',
                'perihal.required' => 'Perihal harus diisi',
                'tempat_tugas.required' => 'Tempat Tugas harus diisi',
                'pegawai_id.required' => 'Nama Pegawai harus diisi',
                'jenis_angkutan.required' => 'Jenis Angkkutan harus diisi',
                'jenis_tugas.required' => 'Jenis Tugas harus diisi',
                'file.required' => 'File harus diisi',
            ]
        );
        return $validate_data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page = "create";
        $title = "Tambah Penugasan";
        $pegawai = Pegawai::all();
        return view("penugasan.tugas.create_edit",compact("pegawai","page","title"));
    }

    public function detail($id)
    {
        $data = DB::table('surattugas')->join('pegawai', 'pegawai.id_pegawai', '=', 'surattugas.pegawai_id')
        ->where('surattugas.id', $id)
        ->select('surattugas.*', 'pegawai.*')->first();
        return view("penugasan.tugas.detail",compact("data"));
    }

    public function batal(Request $request)
    {
        $batal = Surattugas::where('surattugas.no_surat',$request->no_surat)->update([
            "keterangan"=>$request->keterangan,"status"=>'batal']);
        return redirect("penugasan")->with('success', 'Penugasan Dibatalkan');
    }

    public function kirim(Request $request)
    {
        $file = Surattugas::where('no_surat',$request->no_surat)->first();
        if($request->file('file') != ""){
            \File::delete(public_path('files/surattugas/'.$file->file));
            $resorce = $request->file('file');
            $fileName   = time().$resorce->getClientOriginalName();
            $resorce->move(\base_path() ."/public/files/surattugas", $fileName);
            
        }
        $kirim = Surattugas::where('surattugas.no_surat',$request->no_surat)->update([
            "keterangan"=>$request->keterangan,"status"=>'kirim',"file"=>$fileName]);
        $pegawai = Surattugas::where('surattugas.no_surat',$request->no_surat)->get();
        foreach($pegawai as $row){
            $this->sendNotification($row->pegawai_id, $request->no_surat);
        }
        return redirect("penugasan")->with('success', 'Penugasan Dikirimkan');
    }

    public function selesai(Request $request)
    {
        $file = Surattugas::where('no_surat',$request->no_surat)->first();
        $resorce = $request->file('file');
        $fileName   = Carbon::now()->toDateString().'-'.$resorce->getClientOriginalName();
        $resorce->move(\base_path() ."/public/files/tugas", $fileName);
        $selesai = Surattugas::where('surattugas.no_surat',$request->no_surat)->update([
            "keterangan"=>$request->keterangan,"status"=>'selesai',"bukti_file"=>$fileName]);
        return redirect("penugasan")->with('success', 'Penugasan Diselesaikan');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    //    $this->validation($request);
        $input = $request->all();
        //$input['pegawai_id'] = json_encode($input['pegawai_id']);
        $resorce = $request->file('file');
        $fileName   = Carbon::now()->toDateString().'-'.$resorce->getClientOriginalName();
        $resorce->move(\base_path() ."/public/files/tugas", $fileName);
        for($i = 0; $i < count($input['pegawai_id']); $i++){
            $this->sendNotification($input['pegawai_id'][$i],$request->no_surat);
            $tugas = Surattugas::create($request->except(['pegawai_id','file'])+[
                'pegawai_id' => $input['pegawai_id'][$i],
                'file' => $fileName
            ]);
        }
        return redirect('penugasan')->with('success','Berhasil Menambah Data Penugasan');
    }

    public function sendNotification($idPegawai, $nosurat)
    {
        // $notif = new SendFcmNotif();
        // $this->dispatch($notif);
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $token = "AAAA8ebM3Q4:APA91bGAAWqa0LIQbZE-SsGZVx6MueJ32LafTle6nR6TEN91sBX8vnnQsqC6ym1M_B3XLSsG1tZtdNQ1U0WSoTnW-kBxxtzi0RwsWYsPToHppMuNThBUJaBPwz0CnXGE4klI7HTCnnIr";

        $notification = [
            'tipeNotifikasi' => "penugasan",
            'pegawaiId' => $idPegawai,
            'noSurat' => $nosurat
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
    public function update(Request $request)
    {
        $tugas = Surattugas::where('no_surat',$request->no_surat)->update([
            "status"=>$request->status,
            "keterangan"=>$request->keterangan]);
        return redirect('penugasan')->with('success','Berhasil Mengupdate Data Penugasan dengan no. surat '.$request->no_surat);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tugas = Surattugas::where('no_surat',$id)->first();
        \File::delete(public_path('files/tugas/'.$tugas->file));
        $tugas = Surattugas::where('no_surat',$id)->delete();
        return redirect('penugasan')->with('success','Berhasil Menghapus Data Penugasan');
    }
}
