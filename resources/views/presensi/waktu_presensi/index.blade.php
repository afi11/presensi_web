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
                Waktu Presensi {{ getTimeNow() }}
              </li>
            </ol>
        </nav>
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>Data Waktu Presensi</h2>
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
                <a href="{{ route("waktu_presensi.create") }}" class="btn btn-success btn-pill mb-3"> <i class="fas fa-plus"></i> Tambah Waktu Presensi</a>
                <table id="data" class="table dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Hari</td>
                            <td>Jam Presensi</td>
                            <td>Tipe Presensi</td>
                            <td>Tipe Pegawai</td>
                            <td>Aksi</td>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 0; @endphp
                        @foreach ($waktu_presensi as $item) @php $no++; @endphp
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $item->hari }}</td>
                                <td>{{ substr($item->jam_presensi,0,5) }}</td>
                                <td>
                                    @if($item->tipe_presensi == 'jam_pulang') Jam Pulang 
                                    @else 
                                      Jam Masuk
                                    @endif</td>
                                <td>@if($item->nama_tipe == null) Semua Pegawai @else {{ $item->nama_tipe }}  @endif</td>
                                <td>
                                    <a href="{{ route("waktu_presensi.edit",$item->id_waktu) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" data-toggle="modal" data-target="#exampleModal{{ $item->id_waktu }}" 
                                        class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>

                            <div class="modal fade" id="exampleModal{{ $item->id_waktu }}" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah waktu presensi pada hari {{ $item->hari }} , 
                                            jam {{ $item->jam_presensi }} akan dihapus ?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger btn-pill" data-dismiss="modal">Tidak</button>
                                            <form action="{{ route('waktu_presensi.destroy', $item->id_waktu) }}" method="post"> 
                                                @csrf
                                                @method('DELETE')    
                                                <button type="submit" class="btn btn-primary btn-pill">Ya</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection