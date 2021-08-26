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
                    <a href="{{ route("ketidakhadiran.index") }}">Daftar Ketidakhadiran            
                    </a>
                  </li>
                  <li class="breadcrumb-item text-success" aria-current="page">
                    @if($page == "edit")Edit @else Tambah @endif Ketidakhadiran
                  </li>
                </ol>
            </nav>
            <div class="card card-default">
                <div class="card-header card-header-border-bottom">
                    <h2>@if($page == "edit")Edit @else Tambah @endif Data Ketidakhadiran</h2>
                </div>
                <div class="card-body">
                    @if($page == "edit")
                        @php $url = url("ketidakhadiran/add")  @endphp
                    @else
                        @php $url = url("ketidakhadiran/add")  @endphp
                    @endif
                    <form action="{{ $url }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @if($page == "edit")
                            {{ method_field('put') }}
                        @endif
                        <div class="form-group">
                            <label>Lama Izin <strong class="text-danger">*</strong></label>
                            <div class="row">
                                <div class="col-6">
                                    <input type="text" name="tgl_start_izin" class="form-control tgl_awal @error('tgl_start_izin') is-invalid @enderror"
                                        @if($page == "edit") value="{{ $tidakhadir->tgl_start_izin }}" @endif />
                                    @error('tgl_start_izin')
                                        <div class="invalid-feedback">
                                            {{ $message }}  
                                        </div>
                                    @enderror 
                                </div>
                                <div class="col-6">
                                    <input type="text" name="tgl_end_izin" class="form-control tgl_akhir @error('tgl_end_izin') is-invalid @enderror"
                                        @if($page == "edit") value="{{ $tidakhadir->tgl_end_izin }}" @endif />
                                    @error('tgl_end_izin')
                                        <div class="invalid-feedback">
                                            {{ $message }}  
                                        </div>
                                    @enderror 
                                </div>
                            </div>   
                        </div>
                        <div class="form-group">
                            <label>Pegawai <strong class="text-danger">*</strong></label>
                            <select class="form-control @error('pegawai_id') is-invalid @enderror" name="pegawai_id">
                                <option value="">Pilih salah satu</option>
                                @foreach ($pegawai as $item)
                                    <option value="{{ $item->id_pegawai }}" 
                                        @if($page == "edit") 
                                            @if($item->id_pegawai == $harilibur->pegawai_id) selected @endif
                                        @endif>{{ $item->nip }} || {{ $item->nama }}</option>
                                @endforeach
                            </select>
                            @error('pegawai_id')
                            <div class="invalid-feedback">
                                {{ $message }}  
                            </div>
                        @enderror 
                        </div>
                        <div class="form-group">
                            <label>Tipe Izin</label>
                            <select class="form-control"  @error('tipe_izin') is-invalid @enderror" name="tipe_izin">
                                <option value="">Pilih salah satu</option>
                                <option value="sakit">Sakit</option>
                                <option value="dinas_luar">Dinas Luar Kota</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>File Izin @if($page != "edit")<strong class="text-danger">*</strong> @endif</label>
                            <input type="file" class="form-control-file @error('bukti_izin') is-invalid @enderror" name="bukti_izin" />
                            @error('bukti_izin')
                                <div class="invalid-feedback">
                                    {{ $message }}  
                                </div>
                            @enderror 
                            @if($page == "edit")
                                <a href="{{ asset('files/absensi/'.$tidakhadir->bukti_izin) }}" >Lihat file</a>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Keterangan <strong class="text-danger">*</strong></label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" name="keterangan">
                                @if($page == "edit") 
                                    {{ $rulelibur->keterangan }}
                                @endif
                            </textarea>
                            @error('keterangan')
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