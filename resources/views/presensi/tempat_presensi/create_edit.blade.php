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
                    <a href="{{ route("tempat_presensi.index") }}">Daftar Tempat Presensi             
                    </a>
                  </li>
                  <li class="breadcrumb-item text-success" aria-current="page">
                    @if($page == "edit")Edit @else Tambah @endif Tempat Presensi
                  </li>
                </ol>
            </nav>
            <div class="card card-default">
                <div class="card-header card-header-border-bottom">
                    <h2>@if($page == "edit")Edit @else Tambah @endif Data Tempat Presensi</h2>
                </div>
                <div class="card-body">
                    @if(Session::has('error'))
                        <div class="alert alert-dismissible fade show alert-danger" role="alert">
                            {{ Session::get("error") }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    @endif
                    @if($page == "edit")
                        @php $url = route('tempat_presensi.update', $tempat_presensi->id)  @endphp
                    @else
                        @php $url = url("tempat_presensi")  @endphp
                    @endif
                    <form action="{{ $url }}" method="post">
                        @csrf
                        @if($page == "edit")
                            {{ method_field('put') }}
                        @endif
                        <div class="form-group">
                            <label>Nama Tempat Presensi</label>
                            <input type="text" name="nama_tempat" class="form-control @error('nama_tempat') is-invalid @enderror" 
                                placeholder="Contoh : Kantor Kemenag Jombang" 
                                @if($page == "edit") value="{{ $tempat_presensi->nama_tempat }}" @endif />
                                @error('nama_tempat')
                                    <div class="invalid-feedback">
                                        {{ $message }}  
                                    </div>
                                @enderror    
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror" 
                                placeholder="Contoh : Jl. Pattimura 26 Jombang" 
                                @if($page == "edit") value="{{ $tempat_presensi->alamat }}" @endif />
                                @error('alamat')
                                    <div class="invalid-feedback">
                                        {{ $message }}  
                                    </div>
                                @enderror    
                        </div>
                        <div class="form-group">
                            <label>Lokasi Tempat Presensi</label><br/>
                            <span>Klik salah peta untuk mendapatkan lokasi atau ketik lokasi pada form yang tersedia.</span>
                            <div id="mapLokasiTempat" class="mapLokasiTempat"></div>
                            <div class="row">
                                <div class="col-6">
                                    <input type="text" name="latitude_tempat" class="lat_tempat form-control @error('latitude_tempat') is-invalid @enderror"
                                        placeholder="Contoh : -7.82939" 
                                        @if($page == "edit") value="{{ $tempat_presensi->latitude_tempat }}" @endif />
                                    @error('latitude_tempat')
                                        <div class="invalid-feedback">
                                            {{ $message }}  
                                        </div>
                                    @enderror 
                                </div>
                                <div class="col-6">
                                    <input type="text" name="longitude_tempat" class="long_tempat form-control @error('longitude_tempat') is-invalid @enderror" 
                                        placeholder="Contoh : 110.129293" 
                                        @if($page == "edit") value="{{ $tempat_presensi->longitude_tempat }}" @endif />
                                    @error('longitude_tempat')
                                        <div class="invalid-feedback">
                                            {{ $message }}  
                                        </div>
                                    @enderror 
                                </div>
                            </div>   
                        </div>
                        <div class="form-footer pt-4 pt-5 mt-4 border-top">
                            <button type="submit" class="btn btn-primary btn-default">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        var latTempatEdit = JSON.parse(`<?php echo $tempat_presensi->latitude_tempat ?? ''; ?>`);
        var longTempatEdit = JSON.parse(`<?php echo $tempat_presensi->longitude_tempat ?? ''; ?>`);
    </script>
@endsection