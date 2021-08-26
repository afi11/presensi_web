<?php

namespace App\Http\Controllers\Penugasan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use App\Pegawai;
use App\Surattugas;

class SuratController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Surat Tugas";
        $pegawai = Pegawai::all();
        return view("penugasan.surat.index",compact("title","pegawai"));
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
    public function store(Request $request)
    {
        $message = [
            'required' => ':attribute wajib diisi!!!',
        ];
        $this->validate($request,[
                'no_surat' => 'required',
        ], $message);
        $input = $request->all();
        $no_surat = $request->no_surat;
        $menimbang = $request->menimbang;
        $dasar = $request->dasar;
        $tempat_tugas = $request->tempat_tugas;
        $perihal = $request->perihal;
        $tgl_berangkat = $request->tgl_berangkat;
        $keterangan = $request->keterangan;
        $atas_nama = $request->atas_nama;
        $tembusan = $request->tembusan;
      
        $fileName = 'Surat_Tugas_'.$no_surat.'.pdf';
        $pdf = PDF::loadView('penugasan.surat.cetak',
            ['no_surat'=>$no_surat,'pegawai' => $input['pegawai_id'],'menimbang'=>$menimbang,'dasar'=>$dasar,'perihal'=>$perihal,'tempat_tugas'=>$tempat_tugas,'tgl_berangkat'=>$tgl_berangkat,'keterangan'=>$keterangan,'atas_nama'=>$atas_nama,'tembusan'=>$tembusan])
            ->setPaper('a4');
        $pdf->save('files/surattugas/'.$fileName);

        for($i = 0; $i < count($input['pegawai_id']); $i++){
            // $this->sendNotification($input['pegawai_id'][$i],$request->no_surat);
            Surattugas::create($request->except(['pegawai_id','file'])+[
                'pegawai_id' => $input['pegawai_id'][$i],
                'file' => $fileName 
            ]);
        }
        return redirect("penugasan")->with('success', 'Berhasil Menambah Penugasan');;
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
}
