<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Halaman Login</title>

    <link href="{{ asset('assets/plugins/nprogress/nprogress.css') }}" rel="stylesheet" />
    <link id="sleek-css" rel="stylesheet" href="{{ asset('assets/css/sleek.css') }}" />

    <script src="{{ asset('assets/plugins/nprogress/nprogress.js') }}"></script>
</head>
<body>
    <div class="container d-flex flex-column justify-content-between vh-100">
        <div class="row justify-content-center mt-5">
          <div class="col-xl-5 col-lg-6 col-md-10">
            <div class="card">
              <div class="card-header bg-primary">
                <div class="app-brand">
                  <a href="/index.html">
                    <svg class="brand-icon" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid" width="30" height="33"
                      viewBox="0 0 30 33">
                      <g fill="none" fill-rule="evenodd">
                        <path class="logo-fill-blue" fill="#7DBCFF" d="M0 4v25l8 4V0zM22 4v25l8 4V0z" />
                        <path class="logo-fill-white" fill="#FFF" d="M11 4v25l8 4V0z" />
                      </g>
                    </svg>
                    <span class="brand-name">Sleek Dashboard</span>
                  </a>
                </div>
              </div>
              <div class="card-body p-5">
  
                <h4 class="text-dark mb-5">Sign In</h4>
                <form action="/index.html">
                  <div class="row">
                    <div class="form-group col-md-12 mb-4">
                      <input type="email" class="form-control input-lg" id="email" placeholder="Username">
                    </div>
                    <div class="form-group col-md-12 ">
                      <input type="password" class="form-control input-lg" id="password" placeholder="Password">
                    </div>
                    <div class="col-md-12">
                      <button type="submit" class="btn btn-lg btn-primary btn-block mb-4">Sign In</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="copyright pl-0">
          <p class="text-center">&copy; 2021 
          </p>
        </div>
      </div>
</body>
</html>