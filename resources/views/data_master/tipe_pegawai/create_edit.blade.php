@extends('templates.main')
@section('title', $title)
@section('content')			
    <div class="row justify-content-center">
        <div class="col-md-8">
            <nav aria-label="breadcrumb" class="mb-2">
                <ol class="breadcrumb p-0">
                  <li class="breadcrumb-item">
                    <a href="{{ url("/") }}">
                      <span class="mdi mdi-home"></span>                
                    </a>
                  </li>
                  <li class="breadcrumb-item">
                    <a href="{{ route("tempat_tugas.index") }}">Daftar Tempat Tugas             
                    </a>
                  </li>
                  <li class="breadcrumb-item text-success" aria-current="page">
                    @if($page == "edit")Edit @else Tambah @endif Tempat Tugas
                  </li>
                </ol>
            </nav>
            <div class="card card-default">
                <div class="card-header card-header-border-bottom">
                    <h2>@if($page == "edit")Edit @else Tambah @endif Data Tempat Tugas</h2>
                </div>
                <div class="card-body">
                    @if($page == "edit")
                        @php $url = route('tempat_tugas.update', $tipe_pegawai->id)  @endphp
                    @else
                        @php $url = url("tempat_tugas")  @endphp
                    @endif
                    <form action="{{ $url }}" method="post">
                        @csrf
                        @if($page == "edit")
                            {{ method_field('put') }}
                        @endif
                        <div class="form-group">
                            <label>Nama Tipe Pegawai</label>
                                <input type="text" name="nama_tipe" class="form-control @error('nama_tipe') is-invalid @enderror" 
                                placeholder="Contoh : ASN Kemenag" @if($page == "edit") value="{{ $tipe_pegawai->nama_tipe }}" @endif />
                                @error('nama_tipe')
                                    <div class="invalid-feedback">
                                        {{ $message }}  
                                    </div>
                                @enderror        
                        </div>
                        <div class="form-footer pt-4 pt-5 mt-4 border-top">
                            <button type="submit" class="btn btn-primary btn-default">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection