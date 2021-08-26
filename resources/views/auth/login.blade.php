<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="{{ asset("logo-kemenag.png") }}" rel="shortcut icon" />
    <title>Halaman Login</title>

    <link href="{{ asset('assets/plugins/nprogress/nprogress.css') }}" rel="stylesheet" />
    <link id="sleek-css" rel="stylesheet" href="{{ asset('assets/css/sleek.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

</head>
</body>

<div class="container d-flex flex-column justify-content-between vh-100">
    <div class="row justify-content-center mt-5">
      <div class="col-xl-5 col-lg-6 col-md-10">
        <div class="card">
          <div class="card-header bg-primary">
            <div class="app-brand">
              <div class="text-center">
                <img class="brand-icon mr-auto ml-2" width="80" height="80" 
                  src="{{ asset('logo-kemenag.png') }}" />
                <h5 class="mt-2 text-white ml-2">Presensi & Penugasan Kemenag Kab Jombang</h5>
              </div>
            </div>
          </div>
          <div class="card-body p-5">
            <h4 class="text-dark mb-3">Sign In</h4>
            @if(Session::has('error'))
            <div class="alert alert-dismissible fade show alert-danger" role="alert">
              {{ Session::get("error") }}
          </div>
						@endif
            <form method="POST" action="{{ route('post_login') }}">
              @csrf
              <div class="row">
                <div class="form-group col-md-12 mb-4">
                  <input type="text" name="username" class="form-control input-lg @error('username') is-invalid @enderror" 
                    value="{{ old('username') }}"  id="username" placeholder="Username..."/>
                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group col-md-12 ">
                  <input type="password" name="password" class="form-control input-lg @error('password') is-invalid @enderror" id="password" 
                    value="{{ old('password') }}" placeholder="Password...">
                    @error('username')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                @enderror
                </div>
                <div class="col-md-12 mt-3">
                  <button type="submit" class="btn btn-lg btn-primary btn-block mb-4 btn-login">Sign In</button>
                  <button class="btn btn-lg btn-primary btn-loading btn-block mb-4 hide" type="button" disabled>
                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                    Loading...
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="copyright pl-0">
      <p class="text-center">&copy; <span id="copy-year"></span>
      </p>
    </div>
  </div>

  <script>
    var d = new Date();
    var year = d.getFullYear();
    document.getElementById("copy-year").innerHTML = year;

    const btnLogin = document.querySelector(".btn-login");
    const btnLoading = document.querySelector(".btn-loading");
    btnLogin.addEventListener("click",function(){
      btnLogin.classList.add("hide");
      btnLoading.classList.remove("hide");
    });
  </script>
</body>
</html>