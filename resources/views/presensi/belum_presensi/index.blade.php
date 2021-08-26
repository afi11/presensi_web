@extends('templates.main')
@section('title',$title)
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <nav aria-label="breadcrumb" class="mb-2">
            <ol class="breadcrumb p-0">
              <li class="breadcrumb-item">
                <a href="{{ url("/") }}">
                  <span class="mdi mdi-home"></span>                
                </a>
              </li>
              <li class="breadcrumb-item text-success" aria-current="page">
                Pegawai Belum Presensi
              </li>
            </ol>
        </nav>
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>Pegawai Belum Presensi Hari Ini </h2>
            </div>
            <div class="card-body">
                <div class="alert alert-dismissible fade alert-success notif-pemberitahuan hide" role="alert">
                    Berhasil mengirim pemberitahuan waktu presensi!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="row mb-3">
                    <div class="col-4">
                        <select class="form-control tipe_pegawai" onchange="selectTipePegawai()" name="tipe_pegawai">
                            <option value="">Tipe Pegawai - Pilih salah satu</option>   
                            @foreach($tipePegawai as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_tipe }}</option>
                            @endforeach 
                        </select>   
                    </div>
                    <div class="col-4">
                        <select class="form-control" id="tipe_presensi" onchange="selectTipePresensi()" name="tipe_presensi">
                            <option value="">Tipe Presensi - Pilih salah satu</option>   
                            <option value="jam_masuk">Jam Masuk</option>  
                            <option value="jam_pulang">Jam Pulang</option>   
                        </select>    
                    </div>
                    <div class="col-4">
                        <button class="btn btn-primary btnSendNotification" onclick="sendNotifAllPegawai()">Kirim Pemberitahuan</button>
                    </div>
                </div>
                <div class="basic-data-table">
                    <table class="table dt-responsive nowrap table-bordered dt-responsive nowrap data-table" style="width:100%">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Pegawai</td>
                                <td>Jabatan</td>
                                <td>Jam Masuk</td>
                                <td>Jam Pulang</td>
                                <td>Tempat Presensi</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection