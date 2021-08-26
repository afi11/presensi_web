<?php

namespace App\Http\Controllers\Presensi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\RuleHariLibur;
use App\TipePegawai;

class RuleHariLiburController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rulelibur = RuleHariLibur::leftjoin('tipe_pegawai','tipe_pegawai.id','=','rule_hari_libur.id_tipepegawai')->get();
        $title = "Rule Hari Libur";
        return view('presensi.rule_hari_libur.index',compact('rulelibur','title'));
    }

    public function validateData($request)
    {
        $validate = $this->validate($request,
            [
                'tanggal' => 'required',
                'id_tipepegawai' => 'required',
                'keterangan' => 'required'
            ],
            [
                'tanggal.required' => "Tanggal Hari Libur Harus diisi",
                'id_tipepegawai.required' => "Tipe Pegawai Harus diisi",
                "keterangan.required" => "Keterangan Libur Harus diisi"
            ]
        );
        return $validate;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Tambah Rule Hari Libur";
        $page = "create";
        $tipe_pegawai = TipePegawai::all();
        return view('presensi.rule_hari_libur.create_edit',
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
        if($request->id_tipepegawai == "all"){
            $rulelibur = RuleHariLibur::create(
                $request->except(['id_tipepegawai']) + [
                    'id_tipepegawai' => null,
                    'all_pegawai' => 1
                ]
            );
        }else{
            $rulelibur = RuleHariLibur::create( $request->all() + [
                'all_pegawai' => 0
            ]);
        }   
        return redirect('rule_hari_libur')->with('success','Berhasil Menambahkan Data Rule Hari Libur'); 
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
        $rulelibur = RuleHariLibur::leftjoin('tipe_pegawai','tipe_pegawai.id','=','rule_hari_libur.id_tipepegawai')
            ->where('rule_hari_libur.id_rulelibur',$id)->first();
        $tipe_pegawai = TipePegawai::all();
        return view('presensi.rule_hari_libur.create_edit',
            compact('title','page','tipe_pegawai','rulelibur'));
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
        $rulelibur = RuleHariLibur::find($id);
        $rulelibur->tanggal = $request->tanggal;
        if($request->id_tipepegawai == "all"){
            $rulelibur->id_tipepegawai = null;
            $rulelibur->all_pegawai = 1;
        }else{
            $rulelibur->id_tipepegawai = $request->id_tipepegawai;
            $rulelibur->all_pegawai = 0;
        }
        $rulelibur->keterangan = $request->keterangan;
        $rulelibur->save();
        return redirect('rule_hari_libur')->with('success','Berhasil Merubah Data Rule Hari Libur'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rulelibur = RuleHariLibur::find($id);
        $rulelibur->delete();
        return redirect('rule_hari_libur')->with('success','Berhasil Menghapus Data Rule Hari Libur'); 
    }
}
