@extends('templates.main')
@section('title','Halaman Aktivitas')
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
                    Aktivitas Pegawai
                  </li>
                </ol>
            </nav>
            <div class="card card-default">
                <div class="card-header card-header-border-bottom">
                    <h2>Data Aktivitas Pegawai</h2>
                </div>
                <div class="card-body">
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
                            <form action="{{ url('aktifitas/rekap') }}" method="GET">
                                <div class="row">
                                    <div class="form-group mr-2">
                                        <label>Tahun</label>
                                        <select class="form-control years" name="tahun"></select>
                                    </div>
                                    <div class="form-group">
                                        <label>Bulan</label>
                                        <div class="input-group">
                                            <select class="form-control months" name="bulan"></select>
                                            <div class="ml-3">
                                                <button class="btn btn-primary" type="submit">Rekap</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-4">
                                <a href="{{ url('aktifitas/cetak_pdf?tahun='.Request::query('tahun').'&bulan='. Request::query('bulan')) }}" class="btn btn-primary">Rekap PDF</a>
                                <a href="{{ url('aktifitas/export_excel?tahun='.Request::query('tahun').'&bulan='. Request::query('bulan'))}}" class="btn btn-primary">Rekap Excel</a>
                            </div>
                        </div>
                    </div>
                    <table id="data" class="table dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Tanggal</td>
                                <td>Jumlah Aktivitas</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 0; @endphp
                            @foreach ($aktivitas as $item) @php $no++; @endphp
                                <tr>
                                    <td>{{ $no }}</td>
                                    <td>{{ $item->tanggal }}</td>
                                    <td>{{ countAktivitas($item->tanggal) }}</td>
                                    <td>
                                        <a href="{{ route("aktivitas.show",$item->tanggal) }}">
                                            Lihat
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection