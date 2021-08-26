<?php

namespace App\Http\Controllers\Presensi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ExportExcel\PresensiExport;
use App\ExportExcel\PresensiAllExport;
use App\ExportExcel\PresensiGroupExport;
use Maatwebsite\Excel\Facades\Excel;
use DataTables;
use DB;
use App\Pegawai;
use App\TipePegawai;
use App\Periode;
use App\Surattugas;
use PDF;

class PresensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Daftar Presensi Pegawai";
        $tipe = TipePegawai::all();
        return view('presensi.log_presensi.index',compact('title','tipe'));
    }

    public function rekapData(Request $request)
    {
        $pegawai_id = $request->id_pegawai;
        $tipe_rekap = $request->tipe_file;
        $tgl_awal = $request->tgl_awal;
        $tgl_akhir = $request->tgl_akhir;
        $url = url('/printData?pegawai='.$pegawai_id.'&tipe='.$tipe_rekap.'&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir);
        return response()->json($url);
    }

    public function rekapDataKolektif(Request $request)
    {
        $pegawai_id = $request->id_pegawai;
        $tipe_rekap = $request->tipe_file;
        $tgl_awal = $request->tgl_awal;
        $tgl_akhir = $request->tgl_akhir;
        $url = url('/cetak_pdf_kolektif/'.$pegawai_id.'?tipe='.$tipe_rekap.'&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir);
        return response()->json($url);
    }

    public function cetakAllPegawai(Request $request)
    {
        $pegawai_id = $request->id_pegawai;
        $tipe_rekap = $request->tipe_file;
        $tgl_awal = $request->tgl_awal;
        $tgl_akhir = $request->tgl_akhir;
        $url = url('/print_pdf_all_kolektif/'.$pegawai_id.'?tipe='.$tipe_rekap.'&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir);
        return response()->json($url);
    }

    public function printDataAll(Request $request, $id_tipe)
    {
        $tgl_awal = $request->query('tgl_awal');
        $tgl_akhir = $request->query('tgl_akhir');
        $tipeFile = $request->query('tipe');
        $periode = Periode::first();
        $tipe = TipePegawai::find($id_tipe);
        if($tipeFile == 'pdf'){
            $pegawai = Pegawai::join('tipe_pegawai','tipe_pegawai.id','=','pegawai.id_tipepeg')
                ->join('jabatan','jabatan.id','=','pegawai.id_jabatan')
                ->where('pegawai.id_tipepeg',$id_tipe)
                ->select("pegawai.*")
                ->get();
            $pdf = PDF::loadView('presensi.log_presensi.all_group_print_presensi_pdf',
                    ['pegawai' => $pegawai, 'tgl_awal' => $tgl_awal, 'tgl_akhir' => $tgl_akhir, 'periode' => $periode])
                ->setPaper('a4','landscape');
            return $pdf->download('Rekap_Presensi_'.$tipe->nama_tipe.'.pdf');
        }else{
            return Excel::download(new PresensiAllExport($id_tipe, ($tgl_awal == "" ? $periode->periode_awal : $tgl_awal), ($tgl_akhir == "" ? $periode->periode_akhir : $tgl_akhir)), 'Riwayat_Presensi_'.$tipe->nama_tipe.'.xlsx');
        }
    }

    public function printDataCollective(Request $request, $id_pegawai)
    {
        $tgl_awal = $request->query('tgl_awal');
        $tgl_akhir = $request->query('tgl_akhir');
        $periode = Periode::first();
        $tipe = $request->query('tipe');
        $pegawai = Pegawai::join('jabatan','jabatan.id','=','pegawai.id_jabatan')->where('id_pegawai',$id_pegawai)->first();
        if($tipe == 'pdf'){
            //return view('presensi.log_presensi.group_print_presensi_pdf',compact('pegawai','tgl_awal','tgl_akhir'));
            $pdf = PDF::loadView('presensi.log_presensi.group_print_presensi_pdf',
                ['pegawai' => $pegawai, 'tgl_awal' => $tgl_awal, 'tgl_akhir' => $tgl_akhir, 'periode' => $periode])
                ->setPaper('a4');
            return $pdf->download('Rekap_Presensi_'.$pegawai->nama.'.pdf');
        }else{
            return Excel::download(new PresensiGroupExport($id_pegawai, ($tgl_awal == "" ? $periode->periode_awal : $tgl_awal), ($tgl_akhir == "" ? $periode->periode_akhir : $tgl_akhir)), 'Riwayat_Presensi_'.$pegawai->nama.'.xlsx');
        }
    }

    public function printData(Request $request){
        $id_pegawai = $request->query('pegawai');
        $tipe_rekap = $request->query('tipe');
        $tgl_awal = $request->query('tgl_awal');
        $tgl_akhir = $request->query('tgl_akhir');
        $pegawai = Pegawai::join('jabatan','jabatan.id','=','pegawai.id_jabatan')->where('id_pegawai',$id_pegawai)->first();
        if($tipe_rekap == 'pdf'){
            if($tgl_awal == "" || $tgl_akhir == ""){
                $presensi = DB::table('presensi')
                    ->join('pegawai','pegawai.id_pegawai','=','presensi.pegawai_id')
                    ->leftJoin('rule_presensi','rule_presensi.id','=','presensi.id_rulepresensi')
                    ->where('presensi.tipe_izin',null)
                    ->where('presensi.pegawai_id',$id_pegawai)
                    ->groupBy('presensi.tgl_presensi')
                    ->select('presensi.*','pegawai.*','rule_presensi.*')
                    ->get();
            }else{
                $presensi = DB::table('presensi')
                    ->join('pegawai','pegawai.id_pegawai','=','presensi.pegawai_id')
                    ->leftJoin('rule_presensi','rule_presensi.id','=','presensi.id_rulepresensi')
                    ->whereBetween('presensi.tgl_presensi',array($tgl_awal, $tgl_akhir))
                    ->where('presensi.tipe_izin',null)
                    ->where('presensi.pegawai_id',$id_pegawai)
                    ->groupBy('presensi.tgl_presensi')
                    ->select('presensi.*','pegawai.*','rule_presensi.*')
                    ->get();
            }
            //return view('presensi.log_presensi.print_presensi_pdf',compact('presensi','pegawai'));
            $pdf = PDF::loadView('presensi.log_presensi.print_presensi_pdf',
                ['presensi' => $presensi, 'pegawai' => $pegawai, 'tgl_awal' => $tgl_awal, 'tgl_akhir' => $tgl_akhir])
                ->setPaper('a4');
            return $pdf->download('Rekap_Presensi_'.$pegawai->nama.'.pdf');
        }else{
            return Excel::download(new PresensiExport($id_pegawai, $tgl_awal, $tgl_akhir), 'Riwayat Presensi.xlsx');
        }
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

    public function detailPresensi($id)
    {
        $data = DB::table('presensi')
                    ->join('pegawai','pegawai.id_pegawai','=','presensi.pegawai_id')
                    ->leftJoin('rule_presensi','rule_presensi.id','=','presensi.id_rulepresensi')
                    ->where('presensi.id',$id)
                    ->select('presensi.*','pegawai.*','rule_presensi.*')
                    ->orderBy('pegawai.id_pegawai','asc')
                    ->get();
        $detail = array();
        foreach($data as $row){
            if($row->tipe_presensi == 'jam_masuk'){
                $jam_masuk = getJamPresensi($row->pegawai_id, $row->tgl_presensi,'jam_masuk');
                $ket_masuk = getStatusPresensi($row->pegawai_id, $row->tgl_presensi,'jam_masuk');
            }else{
                $jam_pulang = getJamPresensi($row->pegawai_id, $row->tgl_presensi,'jam_pulang'); 
                $ket_pulang = getStatusPresensi($row->pegawai_id, $row->tgl_presensi,'jam_pulang');
            }
            array_push($detail,
                [
                    "tgl_presensi" => $row->tgl_presensi,
                    "jam_masuk" => ($jam_masuk == "" ? "-" : $jam_masuk),
                    "jam_pulang" => ($jam_pulang == "" ? "-" : $jam_pulang),
                    "ket_masuk" => ($ket_masuk == "" ? "-" : $ket_masuk),
                    "ket_pulang" => ($ket_pulang == "" ? "-" : $ket_pulang),
                    "n_telat_masuk" => ($row->tipe_presensi == 'jam_masuk' ? ($row->n_telat == null ? "-" : countLate($row->pegawai_id, $row->tgl_presensi,'jam_masuk')." menit") : "" ),
                    "n_telat_pulang" => ($row->tipe_presensi == 'jam_pulang' ?  ($row->n_telat == null ? "-" : countLate($row->pegawai_id, $row->tgl_presensi,'jam_pulang')." menit") : ""),
                ]
            );
        }
        return response()->json($detail);
    }

    public function show(Request $request,$id)
    {
        $title = "Daftar Presensi Pegawai";
        $pegawai = Pegawai::find($id);
        if($request->ajax()){
            if(!empty($request->tgl_akhir)){
                $data = DB::table('presensi')
                    ->join('pegawai','pegawai.id_pegawai','=','presensi.pegawai_id')
                    ->leftJoin('rule_presensi','rule_presensi.id','=','presensi.id_rulepresensi')
                    ->whereBetween('presensi.tgl_presensi',array($request->tgl_awal, $request->tgl_akhir))
                    ->where('presensi.tipe_izin',null)
                    ->where('presensi.pegawai_id',$id)
                    ->groupBy('presensi.tgl_presensi')
                    ->orderBy('pegawai.id_pegawai','asc')
                    ->select('presensi.*','pegawai.*','rule_presensi.*', 'presensi.id as presensi_id')
                    ->get();
            }else{
                $data = DB::table('presensi')
                    ->join('pegawai','pegawai.id_pegawai','=','presensi.pegawai_id')
                    ->leftJoin('rule_presensi','rule_presensi.id','=','presensi.id_rulepresensi')
                    ->where('presensi.tipe_izin',null)
                    ->where('presensi.pegawai_id',$id)
                    ->groupBy('presensi.tgl_presensi')
                    ->orderBy('pegawai.id_pegawai','asc')
                    ->select('presensi.*','pegawai.*','rule_presensi.*','presensi.id as presensi_id')
                    ->get();
            }
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('waktu_jam_masuk', function($row){
                    $data = getJamPresensi($row->pegawai_id, $row->tgl_presensi,'jam_masuk');
                    return ($data == "" ? "-" : $data);
                })
                ->addColumn('waktu_jam_pulang', function($row){
                    $data = getJamPresensi($row->pegawai_id, $row->tgl_presensi,'jam_pulang');
                    return ($data == "" ? "-" : $data);
                })
                ->addColumn('status_jam_masuk', function($row){
                    $data = getStatusPresensi($row->pegawai_id, $row->tgl_presensi,'jam_masuk');
                    return ($data == "" ? "-" : $data);
                })
                ->addColumn('status_jam_pulang', function($row){
                    $data = getStatusPresensi($row->pegawai_id, $row->tgl_presensi,'jam_pulang');
                    return ($data == "" ? "-" : $data);
                })
                // ->addColumn('action', function($row){
                //     $btn = '<button class="btn btn-primary btn-sm" onclick="showDetPresensi('.$row->presensi_id.')">
                //         <i class="fa fa-eye"></i> Detail
                //     </button>';
                //     return $btn;
                // })
                ->rawColumns(['waktu_jam_masuk','waktu_jam_pulang','status_jam_masuk','status_jam_pulang'])
                ->filter(function($instance) use ($request){
                    if(!empty($request->get('nama_pegawai'))){
                        $instance->collection = $instance->collection->filter(function ($row) use ($request){
                            if($row['pegawai_id'] == $request->get('nama_pegawai')){
                                return true;
                            }
                        });
                    }
                })
                ->make(true);
        }
        return view('presensi.log_presensi.show_pegawai',compact('title','pegawai'));
    }

    public function showPerTempatTugas(Request $request, $id)
    {
        $periode = Periode::first();
        // return response()->json($tampilData);
        $tipePeg = TipePegawai::find($id);
        $title = "Daftar Presensi Pegawai ".$tipePeg->nama_tipe;

        if($request->ajax()){
            $tgl_awal = $request->tgl_awal;
            $tgl_akhir = $request->tgl_akhir;

            $nama_peg = $request->nama_peg;
            if($nama_peg != ""){
                $data = Pegawai::join('tipe_pegawai','tipe_pegawai.id','=','pegawai.id_tipepeg')
                    ->join('jabatan','jabatan.id','=','pegawai.id_jabatan')
                    ->where('pegawai.id_tipepeg',$id)
                    ->select("pegawai.*")
                    ->orderBy("pegawai.id_pegawai","asc")
                    ->get();
            }else{
                $data = Pegawai::join('tipe_pegawai','tipe_pegawai.id','=','pegawai.id_tipepeg')
                ->join('jabatan','jabatan.id','=','pegawai.id_jabatan')
                ->where('pegawai.id_tipepeg',$id)
                ->select("pegawai.*")
                ->orderBy("pegawai.id_pegawai","asc")
                ->get();
            }

            $tampilData = array();
            if(!empty($tgl_akhir)){
                foreach($data as $item){
                    array_push($tampilData,[
                        "id_pegawai" => $item->id_pegawai,
                        "nip" => $item->nip,
                        "nama" => $item->nama,
                        "tl1" => countRangeStatusPresensi($item->id_pegawai, $tgl_awal, $tgl_akhir,'TL-1'),
                        "tl2" => countRangeStatusPresensi($item->id_pegawai, $tgl_awal, $tgl_akhir,'TL-2'),
                        "tl3" => countRangeStatusPresensi($item->id_pegawai, $tgl_awal, $tgl_akhir,'TL-3'),
                        "tl4" => countRangeStatusPresensi($item->id_pegawai, $tgl_awal, $tgl_akhir,'TL-4'),
                        "psw1" => countRangeStatusPresensi($item->id_pegawai, $tgl_awal, $tgl_akhir,'PSW-1'),
                        "psw2" => countRangeStatusPresensi($item->id_pegawai, $tgl_awal, $tgl_akhir,'PSW-2'),
                        "psw3" => countRangeStatusPresensi($item->id_pegawai, $tgl_awal, $tgl_akhir,'PSW-3'),
                        "psw4" => countRangeStatusPresensi($item->id_pegawai, $tgl_awal, $tgl_akhir,'PSW-4'),
                        "tepat_waktu" => countRangeStatusPresensi($item->id_pegawai, $tgl_awal, $tgl_akhir,'-'),
                        "hadir" => countRangeStatusPresensi($item->id_pegawai, $tgl_awal, $tgl_akhir,'masuk'),
                        "izin" => countRangeStatusPresensi($item->id_pegawai, $tgl_awal, $tgl_akhir,null),
                        "tidak_hadir" => countTidakHadir(
                            $item->id_pegawai,
                            $tgl_awal, $tgl_akhir,
                            countRangeStatusPresensi($item->id_pegawai, $tgl_awal, $tgl_akhir,'masuk'),
                            countRangeStatusPresensi($item->id_pegawai, $tgl_awal, $tgl_akhir,null),
                        )
                    ]);
                }
            }else{
                foreach($data as $item){
                    array_push($tampilData,[
                        "id_pegawai" => $item->id_pegawai,
                        "nip" => $item->nip,
                        "nama" => $item->nama,
                        "tl1" => countRangeStatusPresensi($item->id_pegawai, $periode->periode_awal, $periode->periode_akhir,'TL-1'),
                        "tl2" => countRangeStatusPresensi($item->id_pegawai, $periode->periode_awal, $periode->periode_akhir,'TL-2'),
                        "tl3" => countRangeStatusPresensi($item->id_pegawai, $periode->periode_awal, $periode->periode_akhir,'TL-3'),
                        "tl4" => countRangeStatusPresensi($item->id_pegawai, $periode->periode_awal, $periode->periode_akhir,'TL-4'),
                        "psw1" => countRangeStatusPresensi($item->id_pegawai, $periode->periode_awal, $periode->periode_akhir,'PSW-1'),
                        "psw2" => countRangeStatusPresensi($item->id_pegawai, $periode->periode_awal, $periode->periode_akhir,'PSW-2'),
                        "psw3" => countRangeStatusPresensi($item->id_pegawai, $periode->periode_awal, $periode->periode_akhir,'PSW-3'),
                        "psw4" => countRangeStatusPresensi($item->id_pegawai, $periode->periode_awal, $periode->periode_akhir,'PSW-4'),
                        "tepat_waktu" => countRangeStatusPresensi($item->id_pegawai,  $periode->periode_awal, $periode->periode_akhir,'-'),
                        "hadir" => countRangeStatusPresensi($item->id_pegawai,  $periode->periode_awal, $periode->periode_akhir,'masuk'),
                        "izin" => countRangeStatusPresensi($item->id_pegawai, $periode->periode_awal, $periode->periode_akhir,null),
                        "tidak_hadir" => countTidakHadir(
                            $item->id_pegawai,
                            $periode->periode_awal, $periode->periode_akhir,
                            countRangeStatusPresensi($item->id_pegawai, $periode->periode_awal, $periode->periode_akhir,'masuk'),
                            countRangeStatusPresensi($item->id_pegawai, $periode->periode_awal, $periode->periode_akhir,null),
                        )
                    ]);
                }
            }
           
            return DataTables::of($tampilData)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="'.route("log_presensi.show",$row['id_pegawai']).'" class="btn btn-primary btn-sm">Lihat <span class="fa fa-eye"></span></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('presensi.log_presensi.log_per_tempat_tugas',compact('title','periode','tipePeg'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
