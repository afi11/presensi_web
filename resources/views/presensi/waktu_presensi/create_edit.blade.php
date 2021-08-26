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
                    <a href="{{ route("waktu_presensi.index") }}">Daftar Waktu Presensi             
                    </a>
                  </li>
                  <li class="breadcrumb-item text-success" aria-current="page">
                    @if($page == "edit")Edit @else Tambah @endif Waktu Presensi
                  </li>
                </ol>
            </nav>
            <div class="card card-default">
                <div class="card-header card-header-border-bottom">
                    <h2>@if($page == "edit")Edit @else Tambah @endif Data Waktu Presensi</h2>
                </div>
                <div class="card-body">
                    @if($page == "edit")
                        @php $url = route('waktu_presensi.update', $waktu_presensi->id_waktu)  @endphp
                    @else
                        @php $url = url("waktu_presensi")  @endphp
                    @endif
                    @if(Session::has('error'))
                        <div class="alert alert-dismissible fade show alert-danger" role="alert">
                            {{ Session::get("error") }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    @endif
                    <form action="{{ $url }}" method="post">
                        @csrf
                        @if($page == "edit")
                            {{ method_field('put') }}
                        @endif
                        <div class="form-group">
                            <label>Hari <strong class="text-danger">*</strong></label>
                            <select class="form-control  @error('hari') is-invalid @enderror" name="hari">
                                <option value="">Pilih salah satu<option>
                                <option value="Sunday"
                                    @if($page == "edit")
                                       @if($waktu_presensi->hari == 'Sunday') 
                                           selected 
                                       @endif
                                   @endif>Minggu</option>
                                <option value="Monday"
                                     @if($page == "edit")
                                         @if($waktu_presensi->hari == 'Monday') 
                                            selected 
                                        @endif
                                     @endif>Senin</option>
                                <option value="Tuesday"
                                    @if($page == "edit")
                                        @if($waktu_presensi->hari == 'Tuesday') 
                                            selected 
                                        @endif
                                    @endif>Selasa</option>
                                <option value="Wednesday"
                                        @if($page == "edit")
                                            @if($waktu_presensi->hari == 'Wednesday') 
                                                selected 
                                            @endif
                                        @endif>Rabu</option>
                                <option value="Thursday"
                                    @if($page == "edit")
                                        @if($waktu_presensi->hari == 'Thursday') 
                                            selected 
                                        @endif
                                    @endif>Kamis</option>
                                <option value="Friday"
                                    @if($page == "edit")
                                        @if($waktu_presensi->hari == 'Friday') 
                                            selected 
                                        @endif
                                    @endif>Jumat</option>
                                 <option value="Saturday"
                                    @if($page == "edit")
                                        @if($waktu_presensi->hari == 'Saturday') 
                                            selected 
                                        @endif
                                    @endif>Sabtu</option>
                            </select>
                            @error('hari')
                                <div class="invalid-feedback">
                                    {{ $message }}  
                                </div>
                            @enderror  
                        </div>
                        <div class="form-group">
                            <label>Jam Presensi <strong class="text-danger">*</strong></label>
                            <input type="time" name="jam_presensi" class="form-control @error('jam_presensi') is-invalid @enderror"
                                @if($page == "edit") value="{{ $waktu_presensi->jam_presensi }}" @endif />
                            @error('jam_presensi')
                                <div class="invalid-feedback">
                                    {{ $message }}  
                                </div>
                            @enderror 
                        </div>
                        <div class="form-group">
                            <label>Tipe Presensi <strong class="text-danger">*</strong></label>                  
                            <select class="form-control @error('tipe_presensi') is-invalid @enderror" name="tipe_presensi">
                                        <option value="">Pilih tipe presensi</option>
                                        <option value="jam_masuk"
                                            @if($page == "edit")
                                                @if($waktu_presensi->tipe_presensi == 'jam_masuk') selected 
                                                @endif
                                            @endif>Jam Masuk</option>
                                        <option value="jam_pulang"
                                            @if($page == "edit")
                                                @if($waktu_presensi->tipe_presensi == 'jam_pulang') selected 
                                                @endif
                                            @endif>Jam Pulang</option>
                                    </select>
                                    @error('tipe_presensi')
                                        <div class="invalid-feedback">
                                            {{ $message }}  
                                        </div>
                                    @enderror 
                        </div>
                        <div class="form-group">
                            <label>Tipe Pegawai</label>
                            <select class="form-control @error('id_tipepegawai') is-invalid @enderror" name="id_tipepegawai">
                                <option value="">Pilih salah satu</option>
                                @foreach ($tipe_pegawai as $item)
                                    <option value="{{ $item->id }}" 
                                        @if($page == "edit") 
                                            @if($item->id == $waktu_presensi->id_tipepegawai) selected @endif
                                        @endif>{{ $item->nama_tipe }}</option>
                                @endforeach
                            </select>
                            @error('id_tipepegawai')
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