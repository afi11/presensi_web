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
                Pegawai Presensi
              </li>
            </ol>
        </nav>
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>Presensi Pegawai</h2>
            </div>
            <div class="card-body">
               <div class="row mb-3">
                   <div class="col-12 mb-3">
                       <img class="img-profil-pegawai" src="{{ asset('files/images_profil/'.$pegawai->foto) }}" />
                   </div>
                    <div class="col-2 mb-2">
                        <h5><strong>NIP</strong></h5>
                    </div>
                    <div class="col-10 mb-2">
                        <h5>{{ $pegawai->nip }}</h5>
                    </div>
                   <div class="col-2">
                       <h5><strong>Nama</strong></h5>
                   </div>
                   <div class="col-10">
                       <h5>{{ $pegawai->nama }}</h5>
                   </div>
               </div>
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-2">Filter Presensi Pegawai</h5>
                        <div class="row mb-0">
                            <div class="form-group ml-3">
                                <label>Tanggal Awal</label>
                                <input type="text" class="tgl_awal form-control form-control-sm " />
                            </div>
                            <div class="form-group ml-3">
                                <label>Tanggal Akhir</label>
                                <div class="input-group">
                                    <input type="text" class="tgl_akhir form-control form-control-sm" />
                                    <div class="ml-3">
                                        <button class="btn btn-danger btn-sm resetFilterLog">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <h5 class="mb-2">Rekap Data Presensi</h5>
                        <label></label>
                        <div>
                            <button class="btn btn-primary btn-sm" onclick="rekapDataKolektif('pdf')">Export pdf</button>
                            <button class="btn btn-primary btn-sm" onclick="rekapDataKolektif('excel')">Export excel</button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <h5 class="mb-2">Rekap Riwayat Data</h5>
                        <label></label>
                        <div>
                            <button class="btn btn-primary btn-sm" onclick="rekapData('pdf')">Export pdf</button>
                            <button class="btn btn-primary btn-sm" onclick="rekapData('excel')">Export excel</button>
                        </div>
                    </div>
                </div> 
                <div class="text-center">
                    <div class="lds-ripple loading hide"><div></div><div></div></div>
                    <div class="link-download"></div>  
                </div>
                <div class="row justify-content-center">
                  
                </div>
                <div class="basic-data-table">
                    <table class="table nowrap table-bordered data-log-presensi" style="width:100%">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Tanggal Presensi</td>
                                <td>Jam Masuk</td>
                                <td>Jam Pulang</td>
                                <td>Status Jam Masuk</td>
                                <td>Status Jam Pulang</td>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalDetPresensi" data-backdrop="static" data-keyboard="false" tabindex="-1">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="staticBackdropLabel">Detail Presensi</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <div class="lds-ripple loading-detail hide"><div></div><div></div></div>
                </div>
                <table class="table nowrap table-detail hide" style="width:100%">
                    <tr>
                        <td>Tanggal Presensi</td>
                        <td class="tgl_presensi"></td>
                    </tr>
                    <tr>
                        <td>Jam Masuk</td>
                        <td class="jam_masuk"></td>
                    </tr>
                    <tr>
                        <td>Jam Pulang</td>
                        <td class="jam_pulang"></td>
                    </tr>
                    <tr>
                        <td>Ket. Jam Masuk</td>
                        <td class="ket_jam_masuk"></td>
                    </tr>
                    <tr>
                        <td>Ket. Jam Pulang</td>
                        <td class="ket_jam_pulang"></td>
                    </tr>
                    <tr>
                        <td>Jumlah Telat Jam Masuk</td>
                        <td class="n_telat_masuk"></td>
                    </tr>
                    <tr>
                        <td>Jumlah Telat Jam Pulang</td>
                        <td class="n_telat_pulang"></td>
                    </tr>
                </table>
            </div>
        </div>
        </div>
    </div>
</div>
<script>
    var url_segment = " {{ Request::segment(2) }}";
</script>
@endsection