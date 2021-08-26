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
                    <a href="{{ route("jabatan.index") }}">Daftar Pegawai             
                    </a>
                  </li>
                  <li class="breadcrumb-item text-success" aria-current="page">
                    @if($page == "edit")Edit @else Tambah @endif Pegawai
                  </li>
                </ol>
            </nav>
            <div class="card card-default">
                <div class="card-header card-header-border-bottom">
                    <h2>@if($page == "edit")Edit @else Tambah @endif Data Pegawai</h2>
                </div>
                <div class="card-body">
                    @if($page == "edit")
                        @php $url = route('pegawai.update', $pegawai->id_pegawai)  @endphp
                    @else
                        @php $url = url("pegawai")  @endphp
                    @endif
                    <form action="{{ $url }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @if($page == "edit")
                            {{ method_field('put') }}
                        @endif
                        <div class="form-group">
                            <label>NIP Pegawai <strong class="text-danger">*</strong></label>
                            <input type="text" name="nip" class="nip_input form-control @error('nip') is-invalid @enderror" 
                                placeholder="NIP Pegawai...." @if($page == "edit") value="{{ $pegawai->nip }}" @endif
                                onchange="shareValueNIP()" />
                            @error('nip')
                                <div class="invalid-feedback">
                                    {{ $message }}  
                                </div>
                            @enderror
                            <span class="text-info text-info-nip-fill"></span>    
                        </div>
                        <div class="form-group">
                            <label>Username <strong class="text-danger">*</strong></label>
                            <input type="text" name="username" class="username_input form-control @error('username') is-invalid @enderror" 
                                placeholder="Username Pegawai...." @if($page == "edit") value="{{ $pegawai->username }}" @endif />
                            @error('username')
                                <div class="invalid-feedback">
                                    {{ $message }}  
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Password @if($page != "edit")<strong class="text-danger">*</strong> @endif</label>
                            <input type="password" name="password" class="password_input form-control @error('password') is-invalid @enderror"
                                placeholder="Password Pegawai...." />
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}  
                                </div>
                            @enderror
                            @if($page == "edit")
                                <span class="text-info">Kosongi apabila tidak ingin mengganti password</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Password Pengingat <strong class="text-danger">*</strong></label>
                            <input type="text" name="password_hint" class="form-control @error('password_hint') is-invalid @enderror"
                                placeholder="Password Pengingat...." @if($page == "edit") value="{{ $pegawai->password_hint }}" @endif/>
                            @error('password_hint')
                                <div class="invalid-feedback">
                                    {{ $message }}  
                                </div>
                            @enderror
                            <span class="text-info">Isikan untuk mengingat password akun pegawai.</span>
                        </div>
                        <div class="form-group">
                            <label>Nama Pegawai <strong class="text-danger">*</strong></label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" 
                                placeholder="Nama Pegawai...." @if($page == "edit") value="{{ $pegawai->nama }}" @endif />
                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}  
                                </div>
                            @enderror    
                        </div>
                        <div class="form-group">
                            <label>Telepon Pegawai <strong class="text-danger">*</strong></label>
                            <input type="text" name="telepon" class="form-control @error('telepon') is-invalid @enderror" 
                                placeholder="Telepon Pegawai...." @if($page == "edit") value="{{ $pegawai->telepon }}" @endif />
                            @error('telepon')
                                <div class="invalid-feedback">
                                    {{ $message }}  
                                </div>
                            @enderror    
                        </div>
                        <div class="form-group">
                            <label>Alamat Pegawai <strong class="text-danger">*</strong></label>
                            <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror">
                                @if($page == "edit") {{ $pegawai->alamat }} @endif
                            </textarea>
                            @error('alamat')
                                <div class="invalid-feedback">
                                    {{ $message }}  
                                </div>
                            @enderror       
                        </div>
                        <div class="form-group">
                            <label>Foto Pegawai @if($page != "edit")<strong class="text-danger">*</strong> @endif</label>
                            <input type="file" class="form-control-file @error('foto') is-invalid @enderror" name="foto" accept="image/*" />
                            @error('foto')
                                <div class="invalid-feedback">
                                    {{ $message }}  
                                </div>
                            @enderror 
                            @if($page == "edit")
                                <img class="img-profil mt-3" src="{{ asset('files/images_profil/'.$pegawai->foto) }}" >
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Jabatan <strong class="text-danger">*</strong></label>
                            <select class="form-control @error('id_jabatan') is-invalid @enderror" name="id_jabatan">
                                <option value="">Pilih salah satu</option>
                                @foreach ($jabatan as $item)
                                    <option value="{{ $item->id }}" 
                                        @if($page == "edit")
                                         @if($item->id == $pegawai->id_jabatan) selected @endif 
                                        @endif>{{ $item->nama_jabatan }}</option>
                                @endforeach
                            </select>
                            @error('id_jabatan')
                            <div class="invalid-feedback">
                                {{ $message }}  
                            </div>
                        @enderror 
                        </div>
                        <div class="form-group">
                            <label>Tempat Tugas <strong class="text-danger">*</strong></label>
                            <select class="form-control @error('id_tipepeg') is-invalid @enderror" name="id_tipepeg">
                                <option value="">Pilih salah satu</option>
                                @foreach ($tipe_pegawai as $item)
                                    <option value="{{ $item->id }}" 
                                        @if($page == "edit") 
                                            @if($item->id == $pegawai->id_tipepeg) selected @endif
                                        @endif>{{ $item->nama_tipe }}</option>
                                @endforeach
                            </select>
                            @error('id_tipepeg')
                            <div class="invalid-feedback">
                                {{ $message }}  
                            </div>
                            @enderror 
                        </div>
                        <div class="form-group">
                            <label>Pangkat <strong class="text-danger">*</strong></label>
                            <select class="form-control pangkat @error('pangkat') is-invalid @enderror" name="pangkat">
                                <option value="">Pilih salah satu</option>
                                <option 
                                    @if($page == "edit")
                                        @if($pegawai->pangkat == "-") selected @endif
                                    @endif
                                    value="-">-</option>
                                <option 
                                    @if($page == "edit")
                                        @if($pegawai->pangkat == "II/a") selected @endif
                                    @endif
                                    value="II/a">II/a</option>
                                <option 
                                    @if($page == "edit")
                                        @if($pegawai->pangkat == "II/b") selected @endif
                                    @endif
                                    value="II/b">II/b</option>
                                <option 
                                    @if($page == "edit")
                                        @if($pegawai->pangkat == "II/c") selected @endif
                                    @endif
                                    value="II/c">II/c</option>
                                <option 
                                    @if($page == "edit")
                                        @if($pegawai->pangkat == "II/d") selected @endif
                                    @endif
                                    value="II/d">II/d</option>
                                <option 
                                    @if($page == "edit")
                                        @if($pegawai->pangkat == "III/a") selected @endif
                                    @endif
                                    value="III/a">III/a</option>
                                <option 
                                    @if($page == "edit")
                                        @if($pegawai->pangkat == "III/b") selected @endif
                                    @endif
                                    value="III/b">III/b</option>
                                <option 
                                    @if($page == "edit")
                                        @if($pegawai->pangkat == "III/c") selected @endif
                                    @endif
                                    value="III/c">III/c</option>
                                <option 
                                    @if($page == "edit")
                                        @if($pegawai->pangkat == "III/d") selected @endif
                                    @endif
                                    value="III/d">II/d</option>
                                <option 
                                    @if($page == "edit")
                                        @if($pegawai->pangkat == "IV/a") selected @endif
                                    @endif
                                    value="IV/a">IV/a</option>
                                <option 
                                    @if($page == "edit")
                                        @if($pegawai->pangkat == "IV/b") selected @endif
                                    @endif
                                    value="IV/b">IV/b</option>
                                <option 
                                    @if($page == "edit")
                                        @if($pegawai->pangkat == "IV/c") selected @endif
                                    @endif
                                    value="IV/c">IV/c</option>
                                <option 
                                    @if($page == "edit")
                                        @if($pegawai->pangkat == "IV/d") selected @endif
                                    @endif
                                    value="IV/d">IV/d</option>
                            </select>
                            @error('pangkat')
                            <div class="invalid-feedback">
                                {{ $message }}  
                            </div>
                            @enderror 
                        </div>
                        <div class="form-group">
                            <label>Golongan <strong class="text-danger">*</strong></label>
                            <select class="form-control @error('golongan') is-invalid @enderror" name="golongan">
                                <option value="">Pilih salah satu</option>
                                <option value="-"
                                    @if($page == "edit")
                                        @if($pegawai->golongan == "-") selected @endif
                                    @endif
                                    >-</option>
                                <option value="Pengatur Muda"
                                    @if($page == "edit")
                                        @if($pegawai->golongan == "Pengatur Muda") selected @endif
                                    @endif
                                    >Pengatur Muda</option>
                                <option value="Pengatur Muda Tk.I"
                                    @if($page == "edit")
                                        @if($pegawai->golongan == "Pengatur Muda Tk. I") selected @endif
                                    @endif
                                    >Pengatur Muda Tk.I</option>
                                <option value="Pengatur"
                                    @if($page == "edit")
                                        @if($pegawai->golongan == "Pengatur") selected @endif
                                    @endif
                                    >Pengatur</option>
                                <option value="Pengatur Tk.I"
                                    @if($page == "edit")
                                        @if($pegawai->golongan == "Pengatur Tk. I") selected @endif
                                    @endif
                                    >Pengatur Tk.I</option>
                                <option value="Penata Muda"
                                    @if($page == "edit")
                                        @if($pegawai->golongan == "Penata Muda") selected @endif
                                    @endif
                                    >Penata Muda</option>
                                <option value="Penata Muda Tk.I"
                                    @if($page == "edit")
                                        @if($pegawai->golongan == "Penata Muda Tk. I") selected @endif
                                    @endif
                                    >Penata Muda Tk.I</option>
                                <option value="Penata"
                                    @if($page == "edit")
                                        @if($pegawai->golongan == "Penata") selected @endif
                                    @endif
                                    >Penata</option>
                                <option value="Penata Tk.I"
                                    @if($page == "edit")
                                        @if($pegawai->golongan == "Penata Tk. I") selected @endif
                                    @endif>Penata Tk.I</option>
                                <option value="Pembina"
                                    @if($page == "edit")
                                        @if($pegawai->golongan == "Pembina") selected @endif
                                    @endif>Pembina</option>
                                <option value="Pembina Tk.I"
                                    @if($page == "edit")
                                        @if($pegawai->golongan == "Pembina Tk. I") selected @endif
                                    @endif>Pembina Tk.I</option>
                                <option value="Pembina Utama Muda"
                                    @if($page == "edit")
                                        @if($pegawai->golongan == "Pembina Utama Muda") selected @endif
                                    @endif>Pembina Utama Muda</option>
                                <option value="Pembina Utama Madya"
                                    @if($page == "edit")
                                        @if($pegawai->golongan == "Pembina Utama Madya") selected @endif
                                    @endif>Pembina Utama Madya</option>
                                <option value="Pembina Utama"
                                    @if($page == "edit")
                                        @if($pegawai->golongan == "Pembina Utama") selected @endif
                                    @endif>Pembina Utama</option>
                            </select>
                            @error('golongan')
                            <div class="invalid-feedback">
                                {{ $message }}  
                            </div>
                            @enderror 
                        </div>
                        <div class="form-group">
                            <label>Tempat Presensi <strong class="text-danger">*</strong></label>
                            <select class="form-control @error('id_tempat') is-invalid @enderror" name="id_tempat">
                                <option value="">Pilih salah satu</option>
                                @foreach ($tempat_presensi as $item)
                                    <option value="{{ $item->id }}" 
                                        @if($page == "edit")
                                            @if($item->id == $pegawai->id_tempat) selected @endif
                                        @endif>{{ $item->nama_tempat }}</option>
                                @endforeach
                            </select>
                            @error('id_tempat')
                            <div class="invalid-feedback">
                                {{ $message }}  
                            </div>
                        @enderror 
                        </div>
                        <strong>Keterangan<span class="text-danger"> * </span>wajib diisi</strong>
                        <div class="form-footer pt-4 pt-5 mt-4 border-top">
                            <button type="submit" class="btn btn-primary btn-default">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection