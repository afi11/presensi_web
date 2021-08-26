<aside class="left-sidebar bg-sidebar">
    <div id="sidebar" class="sidebar">
      <!-- Aplication Brand -->
      <div class="app-brand">
        <a href="{{ url('/') }}" title="Sleek Dashboard">
          <img class="brand-icon mr-auto ml-2" width="60" height="60" 
            src="{{ asset('logo-kemenag.png') }}" />
          <h5 class="mt-2 text-white ml-2">Kemenag Kab Jombang</h5>
        </a>
      </div>
      <!-- begin sidebar scrollbar -->
      <div class="sidebar-scrollbar">
        <!-- sidebar menu -->
        <ul class="nav sidebar-inner" id="sidebar-menu">
            <li class="has-sub expand">
              <a class="sidenav-item-link" href="javascript:void(0)">
                <span class="nav-text">Presensi <br/>Penugasan </span>
              </a>
            </li>
            <li @if(Request::segment(1) == '') class="active" @endif>
                <a class="sidenav-item-link" href="{{ url("/") }}">
                  <i class="mdi mdi-view-dashboard-outline"></i>
                  <span class="nav-text">Dashboard</span>               
                </a>
            </li>  

            <li class="has-sub expand">
                <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#app0"
                  aria-expanded="false" aria-controls="app">
                  <i class="fas fa-user"></i>
                  <span class="nav-text">Pengguna</span> <b class="caret"></b>
                </a>
                <ul class="collapse" id="app0" data-parent="#sidebar-menu">
                  <div class="sub-menu">  
                      <li @if(Request::segment(1) == 'pegawai') class="active" @endif>
                        <a class="sidenav-item-link" href="{{ route("pegawai.index") }}">
                          <span class="nav-text">Pegawai</span>   
                        </a>
                      </li>
                      <li>
                        <a class="sidenav-item-link" href="{{ route('akun.index') }}">
                          <span class="nav-text">Akun</span>   
                        </a>
                      </li>
                  </div>
                </ul>
              </li>  
           
            <li class="has-sub expand">
              <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#app"
                aria-expanded="false" aria-controls="app">
                <i class="fas fa-list"></i>
                <span class="nav-text">Presensi</span> <b class="caret"></b>
              </a>
              <ul class="collapse" id="app" data-parent="#sidebar-menu">
                <div class="sub-menu">  
                  <li @if(Request::segment(1) == 'log_presensi') class="active" @endif>
                    <a class="sidenav-item-link" href="{{ route("log_presensi.index") }}">
                      <span class="nav-text">Presensi Pegawai</span>   
                    </a>
                  </li>
                    <li @if(Request::segment(1) == 'belum_presensi') class="active" @endif>
                      <a class="sidenav-item-link" href="{{ route("belum_presensi.index") }}">
                        <span class="nav-text">Belum Presensi</span>   
                      </a>
                    </li>
                    <li @if(Request::segment(1) == 'ketidakhadiran') class="active" @endif>
                      <a class="sidenav-item-link" href="{{ route("ketidakhadiran.index") }}">
                        <span class="nav-text">Pengajuan Ketidakhadiran / Cuti</span>   
                      </a>
                    </li>
                    <li @if(Request::segment(1) == 'jabatan') class="active" @endif>
                        <a class="sidenav-item-link" href="{{ route("tempat_presensi.index") }}">
                          <span class="nav-text">Tempat Presensi</span>   
                        </a>
                    </li>
                    <li @if(Request::segment(1) == 'waktu_presensi') class="active" @endif>
                        <a class="sidenav-item-link" href="{{ route("waktu_presensi.index") }}">
                          <span class="nav-text">Waktu Presensi</span>   
                        </a>
                    </li>
                    <li @if(Request::segment(1) == 'rule_presensi') class="active" @endif>
                        <a class="sidenav-item-link" href="{{ route("rule_presensi.index") }}">
                          <span class="nav-text">Rule Presensi</span>   
                        </a>
                    </li>
                    <li @if(Request::segment(1) == 'rule_hari_libur') class="active" @endif>
                        <a class="sidenav-item-link" href="{{ route("rule_hari_libur.index") }}">
                          <span class="nav-text">Rule Hari Libur</span>   
                        </a>
                    </li>
                </div>
              </ul>
            </li>

            <li class="has-sub expand">
                <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#app1"
                  aria-expanded="false" aria-controls="app">
                  <i class="fas fa-envelope"></i>
                  <span class="nav-text">Penugasan</span> <b class="caret"></b>
                </a>
                <ul class="collapse" id="app1" data-parent="#sidebar-menu">
                  <div class="sub-menu">
                      <li @if(Request::segment(1) == 'penugasan') class="active" @endif>
                        <a class="sidenav-item-link" href="{{ route("penugasan.index") }}">
                          <span class="nav-text">Penugasan</span>   
                        </a>
                      </li>
                      <li @if(Request::segment(1) == 'aktivitas') class="active" @endif>
                        <a class="sidenav-item-link" href="{{ route("aktivitas.index") }}">
                          <span class="nav-text">Aktivitas</span>   
                        </a>
                      </li>
                  </div>
                </ul>
              </li>  

            <li class="has-sub expand">
                <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#app2"
                  aria-expanded="false" aria-controls="app">
                  <i class="fas fa-folder"></i>
                  <span class="nav-text">Data Master</span> <b class="caret"></b>
                </a>
                <ul class="collapse" id="app2" data-parent="#sidebar-menu">
                  <div class="sub-menu">  
                      <li @if(Request::segment(1) == 'jabatan') class="active" @endif>
                          <a class="sidenav-item-link" href="{{ route("jabatan.index") }}">
                            <span class="nav-text">Data Jabatan</span>   
                          </a>
                      </li>
                      <li @if(Request::segment(1) == 'tempat_tugas') class="active" @endif>
                        <a class="sidenav-item-link" href="{{ route("tempat_tugas.index") }}">
                          <span class="nav-text">Tempat Tugas</span>   
                        </a>
                      </li>
                  </div>
                </ul>
              </li>  
      
        </ul>
      </div>
    </div>
  </aside>