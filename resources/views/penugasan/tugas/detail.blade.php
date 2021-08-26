@extends('templates.main')
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
                    Detail Penugasan
                  </li>
                </ol>
            </nav>
            <div class="card card-default">
                <div class="card-header card-header-border-bottom">
                    <h2>Detail Penugasan</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                        <div class="form-group">
                            <label>Nomor Surat</label>
                            <input type="text" name="no_surat" class="form-control @error('no_surat') is-invalid @enderror" value="{{ $data->no_surat }}" readonly>
                            @error('no_surat')
                            <div class="invalid-feedback">
                                {{ $message }}  
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Tempat Tugas</label>
                            <input type="text" name="tempat_tugas" class="form-control @error('tempat_tugas') is-invalid @enderror" value="{{ $data->tempat_tugas }}" readonly />
                            @error('tempat_tugas')
                                <div class="invalid-feedback">
                                    {{ $message }}  
                                </div>
                            @enderror    
                        </div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <input type="text" name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" value="{{ $data->keterangan }}" readonly />
                            @error('keterangan')
                            <div class="invalid-feedback">
                                {{ $message }}  
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Tembusan</label>
                            <input type="text" name="tembusan" class="form-control @error('tembusan') is-invalid @enderror" value="{{ $data->tembusan }}" readonly />
                            @error('tembusan')
                                <div class="invalid-feedback">
                                    {{ $message }}  
                                </div>
                            @enderror    
                        </div>
                        <div class="form-group">
                        <label>Surat Tugas</label><br/>
                            <a target="blank" href="{{ asset('files/surattugas/'.$data->file) }}"><button class="btn btn-primary btn-sm">Lihat File</button></a>   
                        </div>
                        @if($data->status == "selesai")
                        <div class="form-group">
                        <label>Bukti Penyelesaian Tugas</label><br/>
                            <a target="blank" href="{{ asset('files/tugas/'.$data->bukti_file) }}"><button class="btn btn-primary btn-sm">Lihat File</button></a>   
                        </div>
                        @endif
                        </div>
                        <div class="col-6">
                        <div class="form-group">
                            <label>Pegawai</label>
                            @foreach(listPegawai($data->no_surat ) as $row)
                            <input type="text" name="pegawai[]" class="form-control" value="{{ $row->nama }}" readonly />
                            @endforeach
                            @error('pegawai_id')
                            <div class="invalid-feedback">
                                {{ $message }}  
                            </div>
                        @enderror 
                        </div>
                        <div class="form-group">
                            <label>Tanggal Berangkat</label>
                            <input type="date" name="tgl_berangkat" class="form-control @error('tgl_berangkat') is-invalid @enderror" value="{{ $data->tgl_berangkat }}" readonly />
                            @error('tgl_berangkat')
                                <div class="invalid-feedback">
                                    {{ $message }}  
                                </div>
                            @enderror    
                        </div>
                        <div class="form-group">
                            <label>Tanggal Kembali</label>
                            <input type="date" name="tgl_kembali" class="form-control @error('tgl_kembali') is-invalid @enderror" value="{{ $data->tgl_kembali }}" readonly />
                            @error('tgl_kembali')
                                <div class="invalid-feedback">
                                    {{ $message }}  
                                </div>
                            @enderror    
                        </div>
                        <div class="form-group">
                            <label>Jenis Angkutan</label>
                            <input type="text" name="jenis_angkutan" class="form-control" value="{{ $data->jenis_angkutan }}" readonly />
                            </select>
                            @error('jenis_angkutan')
                                <div class="invalid-feedback">
                                    {{ $message }}  
                                </div>
                            @enderror    
                        </div>
                        <div class="form-group">
                            <label>Jenis Tugas</label>
                            <input type="text" name="file" class="form-control" value="{{ $data->jenis_tugas }}" readonly />
                            @error('jenis_tugas')
                                <div class="invalid-feedback">
                                    {{ $message }}  
                                </div>
                            @enderror    
                        </div>
                        </div>
                        </div>
                        <div class="row p-5" style="margin-top: 50px;">
                            <div class="col-md-12">
                                <div class="modal-area-button">
                                    <a class="btn btn-danger" href="#" data-toggle="modal" data-target="#DangerModalhdbgcl">Batal</a>
                                    <a class="btn btn-warning" href="#" data-toggle="modal" data-target="#WarningModalhdbgcl">Kirim</a>
                                    <a class="btn btn-success" href="#" data-toggle="modal" data-target="#SuccessModalhdbgcl">Selesai</a>
                                </div>
                            </div>
                        </div>
                        <!-- modal selesai -->
                        <div id="SuccessModalhdbgcl" class="modal modal-edu-general default-popup-SuccessModal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header header-color-modal bg-color-1">
                                    <h3 class="modal-title"><span class="text">No. Surat : </span>{{$data->no_surat}}</h3>
                                        <div class="modal-close-area modal-close-df">
                                            <a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
                                        </div>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ url('penugasan/detail/selesai') }}" method="POST" enctype="multipart/form-data">
                                        @method('PUT')
                                        {{csrf_field()}}
                                            <div class="form-group">
                                                <label>File Bukti Tugas</label>
                                                <input type="hidden" name="no_surat" value="{{ $data->no_surat }}"/>
                                                <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" required />
                                                @error('file')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}  
                                                    </div>
                                                @enderror    
                                            </div>
                                            <div class="form-group">
                                                <label>Keterangan:</label>
                                                <textarea class="form-control" id="keterangan" name="keterangan" ></textarea>
                                            </div>
                                            <div class="modal-footer success-md">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-success">Selesai</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end modal selesai -->
                        <!-- modal kirim -->
                        <div id="WarningModalhdbgcl" class="modal modal-edu-general Customwidth-popup-WarningModal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header header-color-modal bg-color-3">
                                        <h3 class="modal-title"><span class="text">No. Surat : </span>{{$data->no_surat}}</h3>
                                        <div class="modal-close-area modal-close-df">
                                            <a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
                                        </div>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ url('penugasan/detail/kirim') }}" method="POST" enctype="multipart/form-data">
                                        @method('PUT')
                                        {{csrf_field()}}
                                            <div class="form-group">
                                                <input type="hidden" name="no_surat" value="{{ $data->no_surat }}"/>
                                                <label>File Surat Tugas</label>
                                                <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" required />
                                                @error('file')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}  
                                                    </div>
                                                @enderror    
                                            </div>
                                            <div class="form-group">
                                                <label>Keterangan:</label>
                                                <textarea class="form-control" id="keterangan" name="keterangan" ></textarea>
                                            </div>
                                            <div class="modal-footer warning-md">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-warning">Kirim</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end modal kirim -->
                        <!-- modal batal -->
                        <div id="DangerModalhdbgcl" class="modal modal-edu-general FullColor-popup-DangerModal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header header-color-modal bg-color-4">
                                    <h3 class="modal-title"><span class="text">No. Surat : </span>{{$data->no_surat}}</h3>
                                        <div class="modal-close-area modal-close-df">
                                            <a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
                                        </div>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ url('penugasan/detail/batal') }}" method="POST" enctype="multipart/form-data">
                                        {{ method_field('put') }}
                                        {{csrf_field()}}
                                            <div class="form-group">
                                            <input type="hidden" name="no_surat" value="{{ $data->no_surat }}"/> 
                                                <label>Keterangan:</label>
                                                <textarea class="form-control" id="keterangan" name="keterangan" ></textarea>
                                            </div>
                                            <div class="modal-footer danger-md">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-danger">Batal</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end modal batal -->
                </div>
            </div>
        </div>
    </div>
@endsection