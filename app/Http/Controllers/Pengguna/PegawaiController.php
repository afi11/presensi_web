<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Pegawai;
use App\User;
use App\Jabatan;
use App\TipePegawai;
use App\TempatPresensi;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pegawai = Pegawai::join("akun","pegawai.userid","=","akun.userid")
            ->join("jabatan","pegawai.id_jabatan","=","jabatan.id")
            ->join("tipe_pegawai","pegawai.id_tipepeg","=","tipe_pegawai.id")
            ->join("tempat_presensi","pegawai.id_tempat","=","tempat_presensi.id")
            ->select("pegawai.*","jabatan.*","akun.*","tipe_pegawai.*","tempat_presensi.*",
                "pegawai.alamat as alamat_peg")->get();
        return view("pengguna.pegawai.index",compact("pegawai"));
    }

    public function validation($request)
    {
        $validate_data = $this->validate(
            $request,
            [
                'nip' => 'required',
                'username' => 'required',
                'password' => 'required',
                'nama' => 'required',
                'alamat' => 'required',
                'pangkat' => 'required',
                'golongan' => 'required',
                'foto' => 'required',
                'id_jabatan' => 'required',
                'id_tipepeg' => 'required',
                'id_tempat' => 'required',
            ],
            [
                'nip.required' => 'NIP pegawai harus diisi',
                'username.required' => 'Username pegawai harus diisi',
                'password.required' => 'Password pegawai harus diisi',
                'nama.required' => 'Nama pegawai harus diisi',
                'alamat.required' => 'Alamat pegawai harus diisi',
                'foto.required' => 'Foto pegawai harus ada',
                'id_jabatan.required' => 'Jabatan pegawai harus diisi',
                'pangkat.required' => 'Pangkat pegawai harus diisi',
                'golongan.required' => 'Golongan pegawai harus diisi',
                'id_tipepeg.required' => 'Tipe pegawai harus diisi',
                'id_tempat.required' => 'Tempat pegawai presensi harus diisi',
            ]
        );
        return $validate_data;
    }

    public function validation2($request)
    {
        $validate_data = $this->validate(
            $request,
            [
                'nip' => 'required',
                'username' => 'required',
                'nama' => 'required',
                'alamat' => 'required',
                'id_jabatan' => 'required',
                'pangkat' => 'required',
                'golongan' => 'required',
                'id_tipepeg' => 'required',
                'id_tempat' => 'required',
            ],
            [
                'nip.required' => 'NIP pegawai harus diisi',
                'username.required' => 'Username pegawai harus diisi',
                'nama.required' => 'Nama pegawai harus diisi',
                'alamat.required' => 'Alamat pegawai harus diisi',
                'id_jabatan.required' => 'Jabatan pegawai harus diisi',
                'pangkat.required' => 'Pangkat pegawai harus diisi',
                'golongan.required' => 'Golongan pegawai harus diisi',
                'id_tipepeg.required' => 'Tipe pegawai harus diisi',
                'id_tempat.required' => 'Tempat pegawai presensi harus diisi',
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
        $title = "Tambah Pegawai";
        $jabatan = jabatan::all();
        $tipe_pegawai = TipePegawai::all();
        $tempat_presensi = TempatPresensi::all();
        return view("pengguna.pegawai.create_edit",
            compact("page","title","jabatan","tipe_pegawai","tempat_presensi"));
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
        $userid = generateRandom(10);
        $user = User::create([
            'userid' => $userid,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'tipeakun' => "peg",
            "password_hint" => $request->password_hint
        ]);

        $resorce = $request->file('foto');
        $fileName = time().$resorce->getClientOriginalName();
        $resorce->move(\base_path() ."/public/files/images_profil", $fileName);

        $pegawai = Pegawai::create($request->except(['username','password','foto'])+[
            'userid' => $userid,
            'foto' => $fileName
        ]);
        return redirect('pegawai')->with('success','Berhasil Menambah Data Pegawai');
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
        $title = "Edit Data Pegawai";
        $pegawai = Pegawai::join("akun","pegawai.userid","=","akun.userid")
            ->join("jabatan","pegawai.id_jabatan","=","jabatan.id")
            ->join("tipe_pegawai","pegawai.id_tipepeg","=","tipe_pegawai.id")
            ->join("tempat_presensi","pegawai.id_tempat","=","tempat_presensi.id")
            ->where("pegawai.id_pegawai",$id)->first();
        $jabatan = Jabatan::all();
        $tipe_pegawai = TipePegawai::all();
        $tempat_presensi = TempatPresensi::all();
        return view("pengguna.pegawai.create_edit",
            compact("page","title","jabatan","tipe_pegawai","tempat_presensi","pegawai"));
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
        $this->validation2($request);
        $pegawai = Pegawai::find($id);
        $akun = User::find($pegawai->userid);
        $akun->username = $request->username;
        if($request->password != ""){
            $akun->password = bcrypt($request->password);
        }
        $akun->password_hint = $request->password_hint;
        $akun->save();

        if($request->file('foto') != ""){
            \File::delete(public_path('files/images_profil/'.$pegawai->foto));
            $resorce = $request->file('foto');
            $fileName   = time().$resorce->getClientOriginalName();
            $resorce->move(\base_path() ."/public/files/images_profil", $fileName);
            $pegawai->foto = $fileName;
        }
        $pegawai->nip = $request->nip;
        $pegawai->nama = $request->nama;
        $pegawai->alamat = $request->alamat;
       
        $pegawai->id_jabatan = $request->id_jabatan;
        $pegawai->pangkat = $request->pangkat;
        $pegawai->golongan = $request->golongan;
        $pegawai->id_tipepeg = $request->id_tipepeg;
        $pegawai->id_tempat = $request->id_tempat;
        $pegawai->save();
        return redirect('pegawai')->with('success','Berhasil Mengubah Pegawai');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $pegawai = Pegawai::find($id);
        $userid = $pegawai->userid;
        \File::delete(public_path('files/images_profil/'.$pegawai->foto));
        $pegawai->delete();
        $user = User::where("userid",$userid)->delete();
        return redirect('pegawai')->with('success','Berhasil Menghapus Pegawai');
    }

    public function all_pegawai(Request $request)
    {
        $search = $request->search;
        if($search == ''){
            $pegawai = Pegawai::orderBy('nama','ASC')->select('id_pegawai','nama')->get();
        }else{
            $pegawai = Pegawai::orderBy('nama','ASC')->select('id_pegawai','nama')->where('nama','like','%'.$search.'%')->get();
        }

        $response = array();
        foreach($pegawai as $data){
            $response[] = array("id" => $data->id_pegawai, "text" => $data->nama);
        }
        return response()->json($response);
    }
}
