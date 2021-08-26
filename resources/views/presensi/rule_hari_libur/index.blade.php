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
                Rule Hari Libur
              </li>
            </ol>
        </nav>
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>Data Rule Hari Libur</h2>
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
                <a href="{{ route("rule_hari_libur.create") }}" class="btn btn-success btn-pill mb-3"> <i class="fas fa-plus"></i> Tambah Rule Hari Libur</a>
                <table id="data" class="table dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Tanggal</td>
                            <td>Tipe Pegawai</td>
                            <td>Keterangan</td>
                            <td>Aksi</td>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 0; @endphp
                        @foreach ($rulelibur as $item) @php $no++; @endphp
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $item->tanggal }}</td>
                                <td>@if($item->nama_tipe == null) Semua Pegawai @else {{ $item->nama_tipe }}  @endif</td>
                                <td>{{ $item->keterangan }}</td>
                                <td>
                                    <a href="{{ route("rule_hari_libur.edit",$item->id_rulelibur) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" data-toggle="modal" data-target="#exampleModal{{ $item->id_rulelibur }}" 
                                        class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>

                            <div class="modal fade" id="exampleModal{{ $item->id_rulelibur }}" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah rule hari libur pada tanggal {{ $item->tanggal }} akan dihapus ?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger btn-pill" data-dismiss="modal">Tidak</button>
                                            <form action="{{ route('rule_hari_libur.destroy', $item->id_rulelibur) }}" method="post"> 
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