<?php

namespace App\Http\Controllers\Presensi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\RulePresensi;

class RulePresensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rule_presensi = RulePresensi::all();
        $title =  "Data Rule Presensi";
        return view('presensi.rule_presensi.index',compact('rule_presensi','title'));
    }

    public function validation($request)
    {
        $validate_data = $this->validate(
            $request,
            [
                'max_telat_awal' => 'required',
                'tipe_presensi' => 'required',
                'status_presensi' => 'required' 
            ],
            [
                'max_telat_awal.required' => 'Maksimal Jam Telat harus diisi',
                'tipe_presensi.required' => 'Tipe Presensi harus diisi',
                'status_presensi.required' => 'Status Presensi harus diisi'
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
        $title = "Tambah Rule Presensi";
        $page = "create";
        return view("presensi.rule_presensi.create_edit",compact('title','page'));
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
        $rule = RulePresensi::create($request->all());
        return redirect('rule_presensi')->with('success','Berhasil Menambahkan Data Rule Presensi');
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
        $title = "Edit Rule Presensi";
        $page = "edit";
        $rule_presensi = RulePresensi::find($id);
        return view("presensi.rule_presensi.create_edit",compact('title','page','rule_presensi'));
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
        $rule = RulePresensi::find($id);
        $rule->max_telat_awal = $request->max_telat_awal;
        $rule->tipe_presensi = $request->tipe_presensi;
        $rule->status_presensi = $request->status_presensi;
        $rule->save();
        return redirect('rule_presensi')->with('success','Berhasil Merubah Data Rule Presensi');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rule = RulePresensi::find($id);
        $rule->delete();
        return redirect('rule_presensi')->with('success','Berhasil Menghapus Data Rule Presensi');
    }
}
