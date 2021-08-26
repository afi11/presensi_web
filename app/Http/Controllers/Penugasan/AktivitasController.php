<?php

namespace App\Http\Controllers\Penugasan;

use App\Aktivitas;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\ExportExcel\AktivitasExport;

class AktivitasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aktivitas = Aktivitas::groupBy('tanggal')->orderBy('tanggal','desc')->get();
        return view("penugasan.aktivitas.index",compact("aktivitas"));
    }

    public function rekap(Request $request)
    {
        $tahun = $request->tahun;
        $bulan = $request->bulan;
        $aktivitas = Aktivitas::whereMonth('tanggal',$bulan)
            ->whereYear('tanggal',$tahun)
            ->get()
            ->unique('pegawai_id');
        return view("penugasan.aktivitas.rekap",compact("aktivitas"));
    }

    public function cetakPdf(Request $request)
    {
        $tahun = $request->tahun;
        $bulan = $request->bulan;
        if($tahun == "" && $bulan == ""){
            $aktifitas = Aktivitas::join('pegawai','pegawai.id_pegawai','=','aktivitas.pegawai_id')
                        ->OrderBy('pegawai.nama')
                        ->get();
        }else{
            $aktifitas = Aktivitas::join('pegawai','pegawai.id_pegawai','=','aktivitas.pegawai_id')
                        ->OrderBy('pegawai.nama')
                        ->whereMonth('tanggal',$bulan)
                        ->whereYear('tanggal',$tahun)
                        ->get();
        }
        $pdf = PDF::loadView('penugasan.aktivitas.rekap.akt_pdf',
                ['aktifitas' => $aktifitas, 'bulan' => $bulan, 'tahun' => $tahun])
                ->setPaper('a4');
        return $pdf->download('Rekap_aktifitas_Bulan_'.$bulan.'_Tahun_'.$tahun.'.pdf');
    }

    public function export_excel(Request $request)
	{
        $tahun = $request->tahun;
        $bulan = $request->bulan;
		return Excel::download(new AktivitasExport($bulan, $tahun), 'Data_Aktivitas_'.'.xlsx');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($tgl)
    {
        $aktivitas = Aktivitas::join('pegawai','pegawai.id_pegawai','=','aktivitas.pegawai_id')
            ->where('aktivitas.tanggal',$tgl)->get();
        return view("penugasan.aktivitas.show",compact("aktivitas"));
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
