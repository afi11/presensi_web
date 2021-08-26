<?php

namespace App\Http\Controllers\DataMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\TipePegawai;

class TipePegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipe_pegawai = TipePegawai::all();
        return view("data_master.tipe_pegawai.index",compact("tipe_pegawai"));
    }

    public function validation($request)
    {
        $validate_data = $this->validate(
            $request,
            [
                'nama_tipe' => 'required',
            ],
            [
                'nama_tipe.required' => 'Tempat Tugas harus diisi'
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
        $title = "Tambah Tempat Tugas";
        return view("data_master.tipe_pegawai.create_edit",compact("page","title"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validation($request);
        $store = TipePegawai::create($request->all());
        return redirect('tempat_tugas')->with('success','Berhasil Menambah Tipe Pegawai');
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
        $page = "edit";
        $title = "Edit Tipe Pegawai";
        $tipe_pegawai = TipePegawai::find($id);
        return view("data_master.tipe_pegawai.create_edit",compact("page","title","tipe_pegawai"));
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
        $this->validation($request);
        $tipe_pegawai = TipePegawai::find($id);
        $tipe_pegawai->nama_tipe = $request->nama_tipe;
        $tipe_pegawai->save();
        return redirect('tempat_tugas')->with('success','Berhasil Mengubah Tipe Pegawai');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tipe_pegawai = TipePegawai::find($id);
        $tipe_pegawai->delete();
        return redirect('tempat_tugas')->with('success','Berhasil Menghapus Tipe Pegawai Pegawai');
    }
}
