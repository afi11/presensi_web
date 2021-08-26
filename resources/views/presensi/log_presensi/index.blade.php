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
                <h2>Daftar Presensi Pegawai</h2>
            </div>
            <div class="card-body">
                <table class="table dt-responsive nowrap table-bordered dt-responsive nowrap" id="data" style="width:100%">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Tempat Tugas</td>
                            <td>Aksi</td>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach ($tipe as $item)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item->nama_tipe }}</td>
                                <td>
                                    <a href="{{ url('log_presensi/group/'.$item->id) }}" class="btn btn-primary btn-sm text-white">Log Presensi</a>
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