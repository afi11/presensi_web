<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('cekakun')->group(function () {
    Route::get('/', "Dashboard\DashboardController@index")->name('dashboard');
    Route::get('test_word/{id}', "Dashboard\DashboardController@testWord");
    Route::resource("jabatan","DataMaster\JabatanController");
    Route::resource("tempat_tugas","DataMaster\TipePegawaiController");
    Route::resource("tempat_presensi","Presensi\TempatPresensiController");
    Route::resource("pegawai","Pengguna\PegawaiController");
    Route::resource("akun","Pengguna\AkunController");
    Route::get("all_pegawai","Pengguna\PegawaiController@all_pegawai");
    Route::resource('rule_presensi','Presensi\RulePresensiController');
    Route::resource('waktu_presensi','Presensi\WaktuPresensiController');
    Route::resource('rule_hari_libur','Presensi\RuleHariLiburController');
    Route::get("logout","Auth\LoginController@logout")->name('logout');
    Route::resource('belum_presensi', 'Presensi\BelumPresensiController');
    Route::resource('log_presensi', 'Presensi\PresensiController');
    Route::get('log_presensi/group/{tipe}','Presensi\PresensiController@showPerTempatTugas');
    Route::post('print_data', 'Presensi\PresensiController@rekapData');
    Route::get('detail_presensi/{pegawai}','Presensi\PresensiController@detailPresensi');
    // Cetak Data
    Route::get('printData','Presensi\PresensiController@printData');
    Route::post('print_data_kolektif', 'Presensi\PresensiController@rekapDataKolektif');
    Route::get('cetak_pdf_kolektif/{pegawai}','Presensi\PresensiController@printDataCollective');
    Route::post('cetak_pdf_all_kolektif','Presensi\PresensiController@cetakAllPegawai');
    Route::get('print_pdf_all_kolektif/{tipe}','Presensi\PresensiController@printDataAll');
    Route::get('presensi_excel/{id}','Presensi\PresensiController@exportExcel');
    //Route::get('log_presensi_pegawai/{id}','Presensi\PresensiController@show');
    Route::post('ketidakhadiran/add', 'Presensi\KetidakhadiranController@addIzin');
    Route::resource('ketidakhadiran', 'Presensi\KetidakhadiranController');
    Route::get('pengajuan_izin_cuti/{idpegawai}/{presensiid}','Presensi\KetidakhadiranController@cetakPengajuanCutiIzin');
    Route::resource('periode','Presensi\PeriodeController');
    Route::post('surat/act','Penugasan\TugasController@update');

    // Penugasan
    Route::get('penugasan/rekap', 'Penugasan\TugasController@rekap');
    Route::get('penugasan/cetak_pdf', 'Penugasan\TugasController@cetakPdf');
    Route::get('penugasan/export_excel', 'Penugasan\TugasController@export_excel');
    Route::resource('penugasan','Penugasan\TugasController');
    Route::get('penugasan/detail/{id}', 'Penugasan\TugasController@detail');
    Route::put('penugasan/detail/batal', 'Penugasan\TugasController@batal');
    Route::put('penugasan/detail/kirim', 'Penugasan\TugasController@kirim');
    Route::put('penugasan/detail/selesai', 'Penugasan\TugasController@selesai');
    Route::resource('surat','Penugasan\SuratController');
    Route::resource('aktivitas','Penugasan\AktivitasController');
    Route::get('aktifitas/rekap', 'Penugasan\AktivitasController@rekap');
    Route::get('aktifitas/cetak_pdf', 'Penugasan\AktivitasController@cetakPdf');
    Route::get('aktifitas/export_excel', 'Penugasan\AktivitasController@export_excel');
});

Route::middleware('sudahlogin')->group(function () {
    Route::get("login","Auth\LoginController@showLoginForm")->name('login');
    Route::post("post_login","Auth\LoginController@post_login")->name('post_login');
});


