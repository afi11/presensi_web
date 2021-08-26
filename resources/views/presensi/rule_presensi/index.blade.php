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
                Rule Presensi
              </li>
            </ol>
        </nav>
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>Data Rule Presensi</h2>
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
                <a href="{{ route("rule_presensi.create") }}" class="btn btn-success btn-pill mb-3"> <i class="fas fa-plus"></i> Tambah Rule Presensi</a>
                <table id="data" class="table dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Maksimal Telat</td>
                            <td>Tipe Presensi</td>
                            <td>Status Presensi</td>
                            <td>Aksi</td>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 0; @endphp
                        @foreach ($rule_presensi as $item) @php $no++; @endphp
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $item->max_telat_awal }}</td>
                                <td>
                                    @if($item->tipe_presensi == 'jam_pulang') Jam Pulang 
                                    @else 
                                      Jam Masuk
                                    @endif</td>
                                <td>{{ $item->status_presensi }}</td>
                                <td>
                                    <a href="{{ route("rule_presensi.edit",$item->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" data-toggle="modal" data-target="#exampleModal{{ $item->id }}" 
                                        class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>

                            <div class="modal fade" id="exampleModal{{ $item->id }}" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah rule presensi dengan maksimal telat {{ $item->max_telat_awal }} , 
                                            tipe presensi {{ $item->tipe_presensi }} akan dihapus ?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger btn-pill" data-dismiss="modal">Tidak</button>
                                            <form action="{{ route('rule_presensi.destroy', $item->id) }}" method="post"> 
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