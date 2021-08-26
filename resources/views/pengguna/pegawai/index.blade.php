@extends('templates.main')
@section('title','Halaman Pegawai')
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
                    Pegawai
                  </li>
                </ol>
            </nav>
            <div class="card card-default">
                <div class="card-header card-header-border-bottom">
                    <h2>Data Pegawai</h2>
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
                    <a href="{{ route("pegawai.create") }}" class="btn btn-success btn-pill mb-3"> <i class="fas fa-plus"></i> Tambah Pegawai</a>
                    <div class="basic-data-table">
                        <table id="data" class="table nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <td>No</td>
                                    <td>NIP</td>
                                    <td>Identitas</td>
                                    <td>Akun</td>
                                    <td>Jabatan, Pangkat, Golongan</td>
                                    <td>Tipe Pegawai</td>
                                    <td>Tempat Presensi</td>
                                    <td>Foto</td>
                                    <td>Aksi</td>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 0; @endphp
                                @foreach ($pegawai as $item) @php $no++; @endphp
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{ $item->nip }}</td>
                                        <td>Nama : {{ $item->nama }}<br/>
                                            Telepon : {{ $item->telepon }}<br/>
                                            Alamat : {{ $item->alamat_peg }}</td>
                                        <td>Username : {{ $item->username }}<br />
                                            Password Pengingat : {{ $item->password_hint }}</td>
                                        <td>{{ $item->nama_jabatan.", ".$item->pangkat.", ".$item->golongan }}</td>
                                        <td>{{ $item->nama_tipe }}</td>
                                        <td>{{ $item->nama_tempat }}</td>
                                        <td><img class="img-profil" src="{{ asset('files/images_profil/'.$item->foto) }}" /></td>
                                        <td>
                                            <a href="{{ route("pegawai.edit",$item->id_pegawai) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" data-toggle="modal" data-target="#exampleModal{{ $item->id_pegawai }}" 
                                                class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="exampleModal{{ $item->id_pegawai }}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah pegawai {{ $item->nama }} akan dihapus ?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger btn-pill" data-dismiss="modal">Tidak</button>
                                                    <form action="{{ route('pegawai.destroy', $item->id_pegawai) }}" method="post"> 
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
    </div>
@endsection