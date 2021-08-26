<?php

namespace App\Http\Controllers\Presensi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Periode;

class PeriodeController extends Controller
{

    public function index()
    {
        $periode = Periode::first();
        return response()->json(["code" => 200, "periode" => $periode]);
    }
    
    public function store(Request $request)
    {
        $count = Periode::count();
        if($count > 0){
            $periode = Periode::where("id",1)
                ->update([
                    "periode_awal" => $request->periode_awal,
                    "periode_akhir" => $request->periode_akhir
                ]);
        }else{
            $periode = Periode::create($request->all());
        }
        return response()->json(["code" => 200]);
    }

}
