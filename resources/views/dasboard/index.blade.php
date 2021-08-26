@extends('templates.main')
@section('title','Halaman Dashboard')
@section('content')					 
    <div class="row">
      <div class="col-md-12">
        <nav aria-label="breadcrumb" class="mb-2">
          <ol class="breadcrumb p-0">
          <li class="breadcrumb-item">
              <a href="{{ url("/") }}">
              <span class="mdi mdi-home"></span>                
              </a>
          </li>
          <li class="breadcrumb-item text-success" aria-current="page">
              Dashboard
          </li>
          </ol>
        </nav>
      </div>
      <div class="col-md-12 mt-3 mb-3">
          <h3>Periode</h3>
          <div class="form-inline mt-2">
              <input type="text" class="tgl_awal periode_awal form-control" name="periode_awal" />
              <label class="ml-2 mr-2">s.d</label>
              <input type="text" class="tgl_akhir periode_akhir form-control" name="periode_akhir" onchange="setPeriode()" />
          </div>
      </div>
       <div class="col-md-12">
          <div class="card card-default">
              <div class="card-header card-header-border-bottom">
                <h2>Presensi Pegawai</h2>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="text-center">
                      <h5><strong>Terlambat Presensi</strong></h5>
                      <canvas height="300" class="jam_masuk chart mt-3"></canvas>
                    </div>
                  </div>
                  <div class="col-md-6 mb-5">
                    <div class="text-center">
                      <h5><strong>Pulang Sebelum Waktu</strong></h5>
                      <canvas height="300" class="jam_pulang chart"></canvas>
                    </div>
                  </div>
                  <div class="col-md-6 m-auto">
                    <div class="text-center">
                      <h5><strong>Presensi Pegawai</strong></h5>
                      <canvas height="300" class="data_det_presensi chart"></canvas>
                    </div>
                  </div>
                </div>
              </div>
          </div>
       </div>
       <div class="col-md-12">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
              <h2>Penugasan Pegawai</h2>
            </div>
            <div class="card-body row justify-content-center">
              <div class="container-graph">
                <canvas height="200" class="tugas"></canvas>
              </div>            
            </div>
        </div>
     </div>
     <div id="snackbar"></div>
    </div>
    <script>
        isDashboardPage = true;
    </script>
@endsection