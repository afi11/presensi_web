<?php

namespace App\Http\Controllers\Presensi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Pegawai;
use App\WaktuPresensi;
use DB;
use Carbon\Carbon;
use DataTables;

class BelumPresensiController extends Controller
{
    
    public function index(Request $request)
    {
        $title = "Pegawai Belum Presensi";
        $tipePegawai = DB::table('tipe_pegawai')->select("*")->get();
        $hariIni = WaktuPresensi::where('hari',getNameDay())->count();

        if($request->ajax()){
            $data = DB::table('pegawai')
                ->join('jabatan','jabatan.id','=','pegawai.id_jabatan')
                ->join('tipe_pegawai','tipe_pegawai.id','=','pegawai.id_tipepeg')
                ->join('tempat_presensi','tempat_presensi.id','=','pegawai.id_tempat')
                ->whereNotIn('pegawai.id_pegawai', function($query){
                    $query->select('pegawai_id')->from('presensi')
                        ->where('tgl_presensi',Carbon::now()->format('Y-m-d'))
                        ->where('tipe_presensi','jam_pulang');
                })
                ->select('pegawai.*', 'tempat_presensi.*', 'jabatan.*', 
                    'tipe_pegawai.*',
                    'tipe_pegawai.id as tipe_pegawai_id')
                ->get();
            
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('jam_masuk', function($row){
                        foreach(GetWaktuPresensi($row->tipe_pegawai_id) as $item){
                            if($item->tipe_presensi == "jam_masuk"){
                                return $item->jam_presensi;
                            }
                        }
                    })
                    ->addColumn('jam_pulang', function($row){
                        foreach(GetWaktuPresensi($row->tipe_pegawai_id) as $item){
                            if($item->tipe_presensi == "jam_pulang"){
                                return $item->jam_presensi;
                            }
                        }
                    })
                    ->addColumn('action', function($row){
                        $btn = '<button class="btn btn-primary btn-sm" onclick="sendNotif('.$row->id_pegawai.','.$row->id_tipepeg.')">
                            <i class="fa fa-bell"></i> Kirim
                        </button>';
                        return $btn;
                    })
                    ->rawColumns(['jam_masuk', 'jam_pulang', 'action'])
                    ->filter(function($instance) use ($request){
                        if(!empty($request->get('tipe_pegawai'))){
                            $instance->collection = $instance->collection->filter(function ($row) use ($request){
                                if($row['tipe_pegawai_id'] == $request->get('tipe_pegawai')){
                                    return true;
                                }
                            });
                        // $intance->where('nama_tipe', $request->get('tipe_pegawai'));
                        }
                        // if(!empty($request->get('search'))){
                        //     $intance->where(function($w) use($request){
                        //         $search = $request->get('search');
                        //         $w->where('nama_tipe',$search);
                        //     });
                        // }
                    })
                    ->make(true);
            
        }
        return view('presensi.belum_presensi.index',compact('title','tipePegawai'));
    }

}
