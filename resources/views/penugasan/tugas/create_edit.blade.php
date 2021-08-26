@extends('templates.main')
@section('title', $title)
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
                  <li class="breadcrumb-item">
                    <a href="{{ route("penugasan.index") }}">Daftar Penugasan             
                    </a>
                  </li>
                  <li class="breadcrumb-item text-success" aria-current="page">
                    @if($page == "edit")Edit @else Tambah @endif Penugasan
                  </li>
                </ol>
            </nav>
            <div class="card card-default">
                <div class="card-header card-header-border-bottom">
                    <h2>Surat Tugas - Dinas Luar</h2>
                </div>
                <div class="card-body">
                    <form action="{{route('surat.store')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                        <div class="form-group">
                            <label>Nomor Surat</label>
                            <input type="text" name="no_surat" class="form-control @error('no_surat') is-invalid @enderror" 
                                placeholder="ex. Kw.13.1/1234/Kp/03.1/29/3/2021"/>
                            @error('no_surat')
                            <div class="invalid-feedback">
                                {{ $message }}  
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Tempat Tugas</label>
                            <input type="text" name="tempat_tugas" class="form-control @error('tempat_tugas') is-invalid @enderror"  />
                            @error('tempat_tugas')
                                <div class="invalid-feedback">
                                    {{ $message }}  
                                </div>
                            @enderror    
                        </div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <input type="text" name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" />
                            @error('keterangan')
                            <div class="invalid-feedback">
                                {{ $message }}  
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Tembusan</label>
                            <input type="text" name="tembusan" class="form-control @error('tembusan') is-invalid @enderror"  />
                            @error('tembusan')
                                <div class="invalid-feedback">
                                    {{ $message }}  
                                </div>
                            @enderror    
                        </div>
                        </div>
                        <div class="col-6">
                        <div class="form-group">
                            <label>Pegawai</label>
                            <select multiple class="selectpicker form-control @error('pegawai_id') is-invalid @enderror" data-live-search="true" name="pegawai_id[]">
                                <option value="">Pilih Pegawai</option>
                                @foreach ($pegawai as $item)
                                    <option value="{{ $item->id_pegawai }}">{{ $item->nama }} </option>
                                @endforeach
                            </select>
                            @error('pegawai_id')
                            <div class="invalid-feedback">
                                {{ $message }}  
                            </div>
                        @enderror 
                        </div>
                        <div class="form-group">
                            <label>Tanggal Berangkat</label>
                            <input type="date" name="tgl_berangkat" class="form-control @error('tgl_berangkat') is-invalid @enderror" />
                            @error('tgl_berangkat')
                                <div class="invalid-feedback">
                                    {{ $message }}  
                                </div>
                            @enderror    
                        </div>
                        <div class="form-group">
                            <label>Tanggal Kembali</label>
                            <input type="date" name="tgl_kembali" class="form-control @error('tgl_kembali') is-invalid @enderror" />
                            @error('tgl_kembali')
                                <div class="invalid-feedback">
                                    {{ $message }}  
                                </div>
                            @enderror    
                        </div>
                        <div class="form-group">
                            <label>Jenis Angkutan</label>
                            <select class="form-control @error('jenis_angkutan') is-invalid @enderror" name="jenis_angkutan">
                                <option value="">Pilih Jenis Angkutan</option>
                                <option value="Dinas">Dinas</option>
                                <option value="Umum">Umum</option>
                                <option value="Pribadi">Pribadi</option>
                            </select>
                            @error('jenis_angkutan')
                                <div class="invalid-feedback">
                                    {{ $message }}  
                                </div>
                            @enderror    
                        </div>
                        <div class="form-group">
                            <label>Jenis Tugas</label>
                            <select class="form-control @error('jenis_tugas') is-invalid @enderror" name="jenis_tugas">
                                <option value="">Pilih Jenis Tugas</option>
                                <option value="Luar Kota">Luar kota</option>
                                <option value="Dalam kota">Dalam Kota</option>
                            </select>
                            @error('jenis_tugas')
                                <div class="invalid-feedback">
                                    {{ $message }}  
                                </div>
                            @enderror    
                        </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <label>Menimbang</label>
                            <textarea class="form-control" id="menimbang" name="menimbang"></textarea>
                        </div>
                        <div class="form-group">
                        <label>Dasar</label>
                            <textarea class="form-control" id="dasar" name="dasar"></textarea>
                        </div>
                        <div class="form-group">
                        <label>Perihal</label>
                            <textarea class="form-control" id="perihal" name="perihal"></textarea>
                        </div>
                        <div class="form-group">
                        <label>Atas Nama</label>
                            <textarea class="form-control" id="an" name="atas_nama"></textarea>
                        </div>
                        <div class="form-footer pt-4 pt-5 mt-4 border-top">
                            <button type="submit" class="btn btn-primary btn-default">Cetak</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection