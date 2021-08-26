<?php

namespace App\Http\Controllers\Presensi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\WaktuPresensi;
use App\TipePegawai;

class WaktuPresensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $waktu_presensi = WaktuPresensi::leftjoin('tipe_pegawai','tipe_pegawai.id','=','waktu_presensi.id_tipepegawai')->get();
        $title = "Waktu Presensi";
        return view('presensi.waktu_presensi.index',compact('waktu_presensi','title'));
    }

    public function dataIsExist($isEdit, $id, $hari, $tipe_presensi, $tipe_pegawai)
    {
        if($isEdit){
            $count = WaktuPresensi::where('id_waktu','<>',$id)
                ->where('hari',$hari)
                ->where('tipe_presensi',$tipe_presensi)
                ->where('id_tipepegawai',$tipe_pegawai)
                ->count();
        }else{
            $count = WaktuPresensi::where('hari',$hari)
                ->where('tipe_presensi',$tipe_presensi)
                ->where('id_tipepegawai',$tipe_pegawai)
                ->count();
        }
        return ($count > 0 ? true : false);
    }

    public function validateData($request)
    {
        $validate = $this->validate($request,
            [
                'hari' => 'required',
                'jam_presensi' => 'required',
                'tipe_presensi' => 'required',
                'id_tipepegawai' => 'required',
            ],
            [
                'hari.required' => 'Hari Presensi Harus Diisi',
                'jam_presensi.required' => 'Jam Presensi Harus Diisi',
                'tipe_presensi.required' => 'Tipe Presensi Harus Diisi',
                'id_tipepegawai.required' => 'Tipe Pegawai Harus Diisi'
            ]);
        return $validate;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Tambah Waktu Presensi";
        $page = "create";
        $tipe_pegawai = TipePegawai::all();
        return view('presensi.waktu_presensi.create_edit',
            compact('title','page','tipe_pegawai'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateData($request);
        if($this->dataIsExist(false,null,$request->hari, $request->tipe_presensi, $request->id_tipepegawai)){
           return redirect()->back()->with('error','Hari dan tipe presensi sebelumnya sudah ada!');
        }else{
            if($request->id_tipepegawai == "all"){
                $waktu_presensi = WaktuPresensi::create(
                    $request->except(['id_tipepegawai']) + [
                        'id_tipepegawai' => null,
                        'all_pegawai' => 1
                    ]
                );
            }else{
                $waktu_presensi = WaktuPresensi::create(
                    $request->all() + [
                        'all_pegawai' => 0
                    ]
                );
            }
            return redirect('waktu_presensi')->with('success','Berhasil Menambahkan Data Waktu Presensi');
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
        $title = "Edit Waktu Presensi";
        $page = "edit";
        $waktu_presensi = WaktuPresensi::leftjoin('tipe_pegawai','tipe_pegawai.id','=','waktu_presensi.id_tipepegawai')
            ->where('waktu_presensi.id_waktu',$id)->first();
        $tipe_pegawai = TipePegawai::all();
        return view('presensi.waktu_presensi.create_edit',
            compact('title','page','tipe_pegawai','waktu_presensi'));
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
        $this->validateData($request);
        if($this->dataIsExist(true,$id,$request->hari, $request->tipe_presensi, $request->id_tipepegawai)){
            return redirect()->back()->with('error','Hari dan tipe presensi sebelumnya sudah ada!');
        }else{
            $waktu_presensi = WaktuPresensi::find($id);
            $waktu_presensi->hari = $request->hari;
            $waktu_presensi->jam_presensi = $request->jam_presensi;
            $waktu_presensi->tipe_presensi = $request->tipe_presensi;
            if($request->id_tipepegawai == "all"){
                $waktu_presensi->id_tipepegawai = null;
                $waktu_presensi->all_pegawai = 1;
            }else{
                $waktu_presensi->id_tipepegawai = $request->id_tipepegawai;
                $waktu_presensi->all_pegawai = 0;
            }
            $waktu_presensi->save();
            return redirect('waktu_presensi')->with('success','Berhasil Mengubah Data Waktu Presensi');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $waktu_presensi = WaktuPresensi::find($id);
        $waktu_presensi->delete();
        return redirect('waktu_presensi')->with('success','Berhasil Menghapus Data Waktu Presensi');
    }
}
