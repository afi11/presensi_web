<?php

namespace App\Http\Controllers\DataMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Jabatan;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jabatan = Jabatan::all();
        return view("data_master.jabatan.index",compact("jabatan"));
    }

    public function validation($request)
    {
        $validate_data = $this->validate(
            $request,
            [
                'nama_jabatan' => 'required',
            ],
            [
                'nama_jabatan.required' => 'Nama jabatan harus diisi'
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
        $title = "Tambah Jabatan Pegawai";
        return view("data_master.jabatan.create_edit",compact("page","title"));
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
        $store = Jabatan::create($request->all());
        return redirect('jabatan')->with('success','Berhasil Menambah Jabatan Pegawai');
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
        $title = "Edit Jabatan Pegawai";
        $jabatan = Jabatan::find($id);
        return view("data_master.jabatan.create_edit",compact("page","title","jabatan"));
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
        $jabatan = Jabatan::find($id);
        $jabatan->nama_jabatan = $request->nama_jabatan;
        $jabatan->save();
        return redirect('jabatan')->with('success','Berhasil Mengubah Jabatan Pegawai');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jabatan = Jabatan::find($id);
        $jabatan->delete();
        return redirect('jabatan')->with('success','Berhasil Menghapus Jabatan Pegawai');
    }
}
