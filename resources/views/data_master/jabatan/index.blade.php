@extends('templates.main')
@section('title','Halaman Jabatan')
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
                    Jabatan Pegawai
                  </li>
                </ol>
            </nav>
            <div class="card card-default">
                <div class="card-header card-header-border-bottom">
                    <h2>Data Jabatan</h2>
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
                    <a href="{{ route('jabatan.create') }}" class="btn btn-success btn-pill mb-3">Tambah Jabatan</a>
                    <table id="data" class="table dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Jabatan</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 0; @endphp
                            @foreach ($jabatan as $item) @php $no++; @endphp
                                <tr>
                                    <td>{{ $no }}</td>
                                    <td>{{ $item->nama_jabatan }}</td>
                                    <td>
                                        <a href="{{ route("jabatan.edit",$item->id) }}" class="btn btn-primary btn-sm">
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
                                                Apakah jabatan {{ $item->nama_jabatan }} akan dihapus ?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger btn-pill" data-dismiss="modal">Tidak</button>
                                                <form action="{{ route('jabatan.destroy', $item->id) }}" method="post"> 
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