<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get("/test",function(){
    return response()->json("Test");
});

Route::post('login', 'Android\AuthController@login');
Route::post('register', 'Android\AuthController@register');
Route::post('logout','Android\AuthController@logout');
Route::get('getuser','Android\AuthController@getUser');

Route::post('presensi','Android\PresensiController@presensi');
Route::get('get_tempat/{id}','Android\PresensiController@showTempat');
Route::get('get_waktu/{id}','Android\PresensiController@showWaktu');
Route::get('get_diff_time','Android\PresensiController@getDiffTime');
Route::get('cek_presensi/{id}','Android\PresensiController@cekPresensi');
Route::get('cek_libur','Android\PresensiController@getLibur');
Route::resource('absensi','Android\AbsensiController');
Route::get('logpresensi/{id}','Android\PresensiController@logPresensi');
Route::get('logabsensi/{id}','Android\AbsensiController@logAbsensi');
Route::post('callnotification','Android\NotificationController@sendNotification');
Route::get('cek_ada_tugas/{id}','Android\PresensiController@cekSedangTugas');
Route::get('cek_ada_izin/{id}','Android\PresensiController@cekSedangIzin');

Route::get('chart_presensi/{id}/{tipe}', 'Android\DashboardController@chartPresensiTipe');
Route::get('chart_tugas/{id}','Android\DashboardController@chartPenugasanBatalorSelesai');
Route::get('logaktivitas/{id}','Android\AktivitasController@logAktivitas');
Route::post('postaktivitas', 'Android\AktivitasController@store');
Route::get('item_dashboard/{pegawai}/{tipepegawai}', 'Android\DashboardController@getItemDashboard');
Route::get('logtugas/{id}', 'Android\SuratController@getLog');
Route::put('update_tugas/{id}', 'Android\SuratController@update');
Route::get('statistik_presensi/{id}', 'Android\PresensiController@statistikPresensi');
Route::get('get_periode','Android\PresensiController@getPeriode');

Route::get('cetak_form_penyelesaian/{id}','Android\TemplatePenyelesaianController@cetakPenyelesaian');