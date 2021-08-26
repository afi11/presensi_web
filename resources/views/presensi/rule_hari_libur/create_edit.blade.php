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
                    <a href="{{ route("rule_hari_libur.index") }}">Daftar Rule Hari Libur             
                    </a>
                  </li>
                  <li class="breadcrumb-item text-success" aria-current="page">
                    @if($page == "edit")Edit @else Tambah @endif Rule Hari Libur
                  </li>
                </ol>
            </nav>
            <div class="card card-default">
                <div class="card-header card-header-border-bottom">
                    <h2>@if($page == "edit")Edit @else Tambah @endif Data Rule Hari Libur</h2>
                </div>
                <div class="card-body">
                    @if($page == "edit")
                        @php $url = route('rule_hari_libur.update', $rulelibur->id_rulelibur)  @endphp
                    @else
                        @php $url = url("rule_hari_libur")  @endphp
                    @endif
                    <form action="{{ $url }}" method="post">
                        @csrf
                        @if($page == "edit")
                            {{ method_field('put') }}
                        @endif
                        <div class="form-group">
                            <label>Tanggal Libur <strong class="text-danger">*</strong></label>
                            <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror"
                                @if($page == "edit") value="{{ $rulelibur->tanggal }}" @endif />
                            @error('tanggal')
                                <div class="invalid-feedback">
                                    {{ $message }}  
                                </div>
                            @enderror 
                        </div>
                        <div class="form-group">
                            <label>Tipe Pegawai <strong class="text-danger">*</strong></label>
                            <select class="form-control @error('id_tipepegawai') is-invalid @enderror" name="id_tipepegawai">
                                <option value="">Pilih salah satu</option>
                                <option value="all"  
                                    @if($page == "edit") 
                                        @if($rulelibur->all_pegawai == 1 )
                                            selected
                                        @endif
                                    @endif >Semua Pegawai</option>
                                @foreach ($tipe_pegawai as $item)
                                    <option value="{{ $item->id }}" 
                                        @if($page == "edit") 
                                            @if($item->id == $rulelibur->id_tipepegawai) selected @endif
                                        @endif>{{ $item->nama_tipe }}</option>
                                @endforeach
                            </select>
                            @error('id_tipepegawai')
                            <div class="invalid-feedback">
                                {{ $message }}  
                            </div>
                        @enderror 
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