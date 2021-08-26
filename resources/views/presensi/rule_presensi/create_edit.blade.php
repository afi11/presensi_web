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
                    <a href="{{ route("rule_presensi.index") }}">Daftar Rule Presensi             
                    </a>
                  </li>
                  <li class="breadcrumb-item text-success" aria-current="page">
                    @if($page == "edit")Edit @else Tambah @endif Rule Presensi
                  </li>
                </ol>
            </nav>
            <div class="card card-default">
                <div class="card-header card-header-border-bottom">
                    <h2>@if($page == "edit")Edit @else Tambah @endif Data Rule Presensi</h2>
                </div>
                <div class="card-body">
                    @if($page == "edit")
                        @php $url = route('rule_presensi.update', $rule_presensi->id)  @endphp
                    @else
                        @php $url = url("rule_presensi")  @endphp
                    @endif
                    <form action="{{ $url }}" method="post">
                        @csrf
                        @if($page == "edit")
                            {{ method_field('put') }}
                        @endif
                        <div class="form-group">
                            <label>Maksimal Telat (*menit)</label>
                            <input type="number" name="max_telat_awal" class="form-control 
                                @error('max_telat_awal') is-invalid @enderror" 
                                placeholder="Contoh : 30" 
                                @if($page == "edit") value="{{ $rule_presensi->max_telat_awal }}" @endif />
                                @error('max_telat_awal')
                                    <div class="invalid-feedback">
                                        {{ $message }}  
                                    </div>
                                @enderror    
                        </div>
                        <div class="form-group">
                            <label>Tipe Presensi</label>                  
                            <select class="form-control @error('tipe_presensi') is-invalid @enderror" name="tipe_presensi">
                                        <option value="">Pilih tipe presensi</option>
                                        <option value="jam_masuk"
                                            @if($page == "edit")
                                                @if($rule_presensi->tipe_presensi == 'jam_masuk') selected 
                                                @endif
                                            @endif>Jam Masuk</option>
                                        <option value="jam_pulang"
                                            @if($page == "edit")
                                                @if($rule_presensi->tipe_presensi == 'jam_pulang') selected 
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
                            <label>Status Presensi</label>
                            <input type="text" placeholder="Contoh : Potongan Terlambat (TL) / Pulang Sebelum Waktu (PSW)" name="status_presensi" class="form-control @error('status_presensi') is-invalid @enderror"
                                @if($page == "edit") value="{{ $rule_presensi->status_presensi }}" @endif />
                            @error('status_presensi')
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