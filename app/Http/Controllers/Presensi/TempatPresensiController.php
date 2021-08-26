<?php

namespace App\Http\Controllers\Presensi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\TempatPresensi;

class TempatPresensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tempat_presensi = TempatPresensi::all();
        return view("presensi.tempat_presensi.index",compact("tempat_presensi"));
    }

    public function dataIsExist($isEdit, $id, $lat,$long)
    {
        if($isEdit){
            $count = TempatPresensi::where('id','<>',$id)
                ->where('latitude_tempat',$lat)
                ->where('longitude_tempat',$long)
                ->count();
        }else{
            $count = TempatPresensi::where('latitude_tempat',$lat)
                ->where('longitude_tempat',$long)
                ->count();
        }
        return ($count > 0 ? true : false);
    }

    public function validation($request)
    {
        $validate_data = $this->validate(
            $request,
            [
                'nama_tempat' => 'required',
                'alamat' => 'required',
                'latitude_tempat' => 'required',
                'longitude_tempat' => 'required'
            ],
            [
                'nama_tempat.required' => 'Tempat presensi harus diisi',
                'alamat.required' => 'Alamat presensi harus diisi',
                'latitude_tempat.required' => 'Latitude tempat presensi harus diisi',
                'longitude_tempat.required' => 'Longitude tempat presensi harus diisi',
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
        $title = "Tambah Tempat Presensi";
        return view("presensi.tempat_presensi.create_edit",compact("page","title"));
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
        if($this->dataIsExist(false,null,$request->latitude_tempat, $request->longitude_tempat)){
            return redirect()->back()->with('error','Lokasi koordinat latitude & longitude sudah ada!');
        }else{
            $tempat_presensi = TempatPresensi::create($request->all());
            return redirect('tempat_presensi')->with('success','Berhasil Menambah Tempat Presensi');
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
        $page = "edit";
        $title = "Edit Tempat Presensi";
        $tempat_presensi = TempatPresensi::find($id);
        return view("presensi.tempat_presensi.create_edit",compact("page","title","tempat_presensi"));
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
        if($this->dataIsExist(true,$id,$request->latitude_tempat, $request->longitude_tempat)){
            return redirect()->back()->with('error','Lokasi koordinat latitude & longitude sudah ada!');
        }else{
            $this->validation($request);
            $tempat_presensi = TempatPresensi::find($id);
            $tempat_presensi->nama_tempat = $request->nama_tempat;
            $tempat_presensi->alamat = $request->alamat;
            $tempat_presensi->latitude_tempat = $request->latitude_tempat;
            $tempat_presensi->longitude_tempat = $request->longitude_tempat;
            $tempat_presensi->save();
            return redirect('tempat_presensi')->with('success','Berhasil Mengubah Tempat Presensi');
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
        $tempat_presensi = TempatPresensi::find($id);
        $tempat_presensi->delete();
        return redirect('tempat_presensi')->with('success','Berhasil Menghapus Tempat Presensi');
    }
}
