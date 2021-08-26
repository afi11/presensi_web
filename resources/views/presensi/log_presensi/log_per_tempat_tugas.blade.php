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
                <h2><strong>Daftar Presensi Pegawai {{ $tipePeg->nama_tipe }}</strong></h2>
            </div>
            <div class="card-body">
                <div class="text-center mb-5">
                    <h4><strong>
                        Periode Presensi {{ $periode->periode_awal }} sd {{ $periode->periode_akhir }}
                    </strong></h4>
                </div>
                @if(Session::has('success'))
                    <div class="alert alert-dismissible fade show alert-success" role="alert">
                        {{ Session::get("success") }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-2">Filter Presensi Pegawai</h5>
                        <div class="row mb-0">
                            <div class="form-group ml-3">
                                <label>Tanggal Awal</label>
                                <input type="text" class="tgl_periode_awal form-control form-control-sm " />
                            </div>
                            <div class="form-group ml-3">
                                <label>Tanggal Akhir</label>
                                <div class="input-group">
                                    <input type="text" class="tgl_periode_akhir form-control form-control-sm" />
                                    <div class="ml-3">
                                        <button class="btn btn-danger btn-sm resetFilterLog">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 ml-auto">
                        <h5 class="mb-2">Rekap Data Presensi</h5>
                        <label></label>
                        <div>
                            <button class="btn btn-primary btn-sm" onclick="rekapDataAll('pdf')">Export pdf</button>
                            <button class="btn btn-primary btn-sm" onclick="rekapDataAll('excel')">Export excel</button>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <div class="textFilter hide"></div>
                </div>
                <div class="text-center">
                    <div class="lds-ripple loading hide"><div></div><div></div></div>
                    <div class="link-download"></div>  
                </div>
                <p class="mb-0">Geser kesamping untuk melihat data lebih lengkap.</p>
                <div class="basic-data-table">
                    <table class="table data-report-presensi dt-responsive nowrap table-bordered dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>NIP</td>
                                <td>Pegawai</td>
                                <td>TL1</td>
                                <td>TL2</td>
                                <td>TL3</td>
                                <td>TL4</td>
                                <td>PSW1</td>
                                <td>PSW2</td>
                                <td>PSW3</td>
                                <td>PSW4</td>
                                <td>Tepat Waktu</td>
                                <td>Masuk</td>
                                <td>Izin</td>
                                <td>Tidak Presensi</td>
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
<script>
    var url_segment = " {{ Request::segment(3) }}";
</script>
@endsection