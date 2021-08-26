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
                    <h2>Data Aktivitas Pegawai Harian</h2>
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
                    <table id="data" class="table dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Tanggal</td>
                                <td>Pegawai</td>
                                <td>Uraian</td>
                                <td>Satuan</td>
                                <td>Kuantitas</td>
                                <td>File</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 0; @endphp
                            @foreach ($aktivitas as $item) @php $no++; @endphp
                                <tr>
                                    <td>{{ $no }}</td>
                                    <td>{{ $item->tanggal}}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->uraian }}</td>
                                    <td>{{ $item->satuan }}</td>
                                    <td>{{ $item->kuantitas }}</td>
                                    <td>
                                            <a target="blank" href="{{ asset('files/aktivitas/'.$item->file) }}">Lihat File</a>
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