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
                    <a href="{{ route("jabatan.index") }}">Daftar Akun             
                    </a>
                  </li>
                  <li class="breadcrumb-item text-success" aria-current="page">
                    @if($page == "edit")Edit @else Tambah @endif Akun
                  </li>
                </ol>
            </nav>
            <div class="card card-default">
                <div class="card-header card-header-border-bottom">
                    <h2>@if($page == "edit")Edit @else Tambah @endif Data Akun</h2>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <strong>Informasi!</strong> untuk menambahkan akun pegawai silahkan lakukan pada menu tambah pegawai.
                    </div>
                    @if($page == "edit")
                        @php $url = route('akun.update', $akun->userid)  @endphp
                    @else
                        @php $url = url("akun")  @endphp
                    @endif
                    <form action="{{ $url }}" method="post">
                        @csrf
                        @if($page == "edit")
                            {{ method_field('put') }}
                        @endif
                        <div class="form-group">
                            <label>Username <strong class="text-danger">*</strong></label>
                            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" 
                                placeholder="Username...." @if($page == "edit") value="{{ $akun->username }}" @endif />
                            @error('username')
                                <div class="invalid-feedback">
                                    {{ $message }}  
                                </div>
                            @enderror 
                        </div>
                        <div class="form-group">
                            <label>Password @if($page != "edit")<strong class="text-danger">*</strong> @endif</label>
                            <input type="password" name="password" class="password_input form-control @error('password') is-invalid @enderror"
                                placeholder="Password...." />
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
                                placeholder="Password Pengingat...." @if($page == "edit") value="{{ $akun->password_hint }}" @endif/>
                            @error('password_hint')
                                <div class="invalid-feedback">
                                    {{ $message }}  
                                </div>
                            @enderror
                            <span class="text-info">Isikan untuk mengingat password akun.</span>
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