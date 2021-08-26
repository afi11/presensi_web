<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class AkunController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $akun = User::where('tipeakun','adm')->get();
        return view('pengguna.akun.index',compact('akun'));
    }


    public function validation($request)
    {
        $validate_data = $this->validate(
            $request,
            [
                'username' => 'required',
                'password' => 'required',
                'password_hint' => 'required',
            ],
            [
                'username.required' => 'Username akun harus diisi',
                'password.required' => 'Password akun harus diisi',
                'password_hint.required' => 'Password petunjuk harus diisi',
            ]
        );
        return $validate_data;
    }

    public function validation2($request)
    {
        $validate_data = $this->validate(
            $request,
            [
                'username' => 'required',
                'password_hint' => 'required',
            ],
            [
                'username.required' => 'Username akun harus diisi',
                'password_hint.required' => 'Password petunjuk harus diisi',
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
        $title = "Tambah Akun";
        return view("pengguna.akun.create_edit", compact("page","title"));
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
        $user = new User();
        $user->userid = $userid;
        $user->username = $request->username;
        $user->tipeakun = "adm";
        $user->password = bcrypt($request->password);
        $user->password_hint = $request->password_hint;
        $user->save();
        return redirect('akun')->with('success','Berhasil Menambah Data Akun Admin');
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
        $title = "Edit Data Akun";
        $akun = User::find($id);
        return view("pengguna.akun.create_edit", compact("page","title","akun"));
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
        $user = User::find($id);
        $user->username = $request->username;
        if($request->password != "")
            $user->password = bcrypt($request->password);
        $user->password_hint = $request->password_hint;
        $user->save();
        return redirect('akun')->with('success','Berhasil Mengubah Data Akun Admin');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $akun = User::find($id);
        $akun->delete();
        return redirect('akun')->with('success','Berhasil Menghapus Data Akun Admin');
    }
}
