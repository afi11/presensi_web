<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="Sleek Dashboard - Free Bootstrap 4 Admin Dashboard Template and UI Kit. It is very powerful bootstrap admin dashboard, which allows you to build products like admin panels, content management systems and CRMs etc.">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title')</title>

  <!-- GOOGLE FONTS -->
  {{-- <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500|Poppins:400,500,600,700|Roboto:400,500" rel="stylesheet" /> --}}
  <link href="https://cdn.materialdesignicons.com/4.4.95/css/materialdesignicons.min.css" rel="stylesheet" />
  <!-- PLUGINS CSS STYLE -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  <link href="{{ asset("assets/plugins/nprogress/nprogress.css") }}" rel="stylesheet" />
  <link href="{{ asset("assets/plugins/data-tables/datatables.bootstrap4.min.css") }}" rel="stylesheet" />
  <link href="{{ asset("assets/plugins/select2/css/select2.min.css") }}" rel="stylesheet" />
  <link href="{{ asset("assets/plugins/jquery/jquery-ui-1.12.1.css") }}" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset("assets/plugins/bootstrap-select.min.css") }}">
  <!-- SLEEK CSS -->
  <link id="sleek-css" rel="stylesheet" href="{{ asset("assets/css/sleek.css") }}" />
  <link rel="stylesheet" href="{{ asset("css/styles.css") }}" />

  <link href='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.css' rel='stylesheet' />

  <!-- FAVICON -->
  <link href="{{ asset("logo-kemenag.png") }}" rel="shortcut icon" />

  <script src="{{ asset("assets/plugins/nprogress/nprogress.js") }}"></script>

  <style>
    .hide {
        display: none;
    }
    .show {
        display: block;
    }
    .img-profil {
        width: 100px;
    }

  </style>
  <script>
    var isDashboardPage = false;
  </script>

</head>


<body class="header-fixed sidebar-fixed sidebar-dark header-light" id="body">
    <script>
        NProgress.configure({ showSpinner: false });
        NProgress.start();
    </script>
    <div class="wrapper">
        @include('templates.sidebar')
        <div class="page-wrapper">
            @include('templates.navbar')
            <div class="content-wrapper">
                <div class="content">	
                    @yield('content')		
                </div>
            </div>
            @include('templates.footer')
        </div>
    </div>
    
    <script src="{{ asset("assets/plugins/jquery/jquery.min.js") }}"></script>
    <script src="{{ asset("assets/plugins/jquery/jquery-ui-1.12.js") }}"></script>
    <script src="{{ asset("assets/plugins/slimscrollbar/jquery.slimscroll.min.js") }}"></script>
    <script src="{{ asset("assets/plugins/jekyll-search.min.js") }}"></script>

    <script src="{{ asset("assets/plugins/charts/chart.min.js") }}"></script>
    <script src="{{ asset("assets/plugins/charts/chartjs-plugin-datalabels.js") }}"></script>

    <script src="{{ asset("assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.js") }}"></script>
    <script src="{{ asset("assets/plugins/jvectormap/jquery-jvectormap-world-mill.js") }}"></script>

    <script src="{{ asset("assets/plugins/daterangepicker/moment.min.js") }}"></script>
    <script src="{{ asset("assets/plugins/daterangepicker/daterangepicker.js") }}"></script>

    <script src="{{ asset("assets/plugins/data-tables/jquery.datatables.min.js") }}"></script>
    <script src="{{ asset("assets/plugins/data-tables/datatables.bootstrap4.min.js") }}"></script>

    <script src="{{ asset("assets/plugins/select2/js/select2.min.js") }}"></script>

    <script src="{{ asset("assets/plugins/bootstrap.bundle.min.js") }}"></script>
    <script src="{{ asset("assets/plugins/bootstrap-select.min.js") }}"></script>

    <script>
        var mainUrl = '{{ url("") }}';
        var urlBelumPresensi = '{{ route("belum_presensi.index") }}';
        var dataPresensiMasuk = JSON.parse(`<?php echo $jam_masuk ?? ''; ?>`);
        var dataPresensiPulang = JSON.parse(`<?php echo $jam_pulang ?? ''; ?>`);
        var dataPresensi = JSON.parse('<?php echo $dataPresensi ?? ''; ?>');
        var dataTugas = JSON.parse(`<?php echo $tugas ?? ''; ?>`);
    </script>

    <script src="{{ asset("js/datatable.js") }}"></script>
    <script src="{{ asset("js/action_presensi.js") }}"></script>
    <script src="{{ asset("js/action_tugas.js") }}"></script>
    <script src="{{ asset("js/select2.js") }}"></script>
    <script src="{{ asset("js/chart.js") }}"></script>
  
    <script src="{{ asset("assets/plugins/toastr/toastr.min.js") }}"></script>
    <script src="{{ asset("assets/js/sleek.bundle.js") }}"></script>

    <script src="https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.js"></script>

    <script>
        $(function(){
             // Belum Presensi
            var table_belum_presensi = $(".data-table").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: urlBelumPresensi,
                    data: function (d) {
                        (d.tipe_pegawai = $(".tipe_pegawai").val()),
                            (d.search = $('input[type="search"]').val());
                    },
                },
                columns: [
                    { data: "DT_RowIndex", name: "DT_RowIndex" },
                    { data: "nama", name: "nama" },
                    { data: "nama_jabatan", name: "nama_jabatan" },
                    { data: "jam_masuk", name: "jam_masuk" },
                    { data: "jam_pulang", name: "jam_pulang" },
                    { data: "nama_tempat", name: "nama_tempat" },
                    { data: "action", name: "action" },
                ],
                responsive: true,
            });
            $(".tipe_pegawai").change(function () {
                table_belum_presensi.draw();
            });
        });

        loadPeriode();
        function loadPeriode(){
            $.ajax({
                url: mainUrl+"/periode",
                method: "GET",
                success: function(res){
                    document.querySelector(".periode_awal").value = res.periode.periode_awal;
                    document.querySelector(".periode_akhir").value = res.periode.periode_akhir;
                }
            });
        }

        // Set Periode
        function setPeriode(){
            var periodeAwal = document.querySelector(".periode_awal").value;
            var periodeAkhir = document.querySelector(".periode_akhir").value;
            const snackBar = document.querySelector("#snackbar");
            var message = "Berhasil mengubah periode";
            $.ajax({
                url: mainUrl+"/periode",
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                data: {
                    periode_awal: periodeAwal,
                    periode_akhir: periodeAkhir
                },
                success: function(res){
                    snackBar.className = "show";
                    snackBar.innerHTML = message;
                    setTimeout(function () {
                        snackBar.className = snackBar.className.replace("show", "");
                        window.location.reload();
                    }, 3000);
                }
            });
        }

        loadGolongan();
        function loadGolongan(){
            var golongan = [
                "Pengatur Muda",
                "Pengatur Muda Tk.I",
                "Pengatur",
                "Pengatur Tk.I",
                "Penata Muda",
                "Penata Muda Tk.I",
                "Penata",
                "Penata Tk.I",
                "Pembina",
                "Pembina Tk.I",
                "Pembina Utama Muda",
                "Pembina Utama Madya",
                "Pembina Utama",
            ];
            var pngkt = document.querySelector(".golongan");
            for (var i = 0; i < golongan.length; i++) {
                var option = document.createElement("option");
                option.value = golongan[i];
                option.innerHTML = golongan[i];
                pngkt.appendChild(option);
            }
        }

        loadPangkat();
        function loadPangkat(){
            var pangkat = [
                "II/a",
                "II/b",
                "II/c",
                "II/d",
                "III/a",
                "III/b",
                "III/c",
                "III/d",
                "IV/a",
                "IV/b",
                "IV/c",
                "IV/d",
            ];
            var pngkt = document.querySelector(".pangkat");
            for (var i = 0; i < pangkat.length; i++) {
                var option = document.createElement("option");
                option.value = pangkat[i];
                option.innerHTML = pangkat[i];
                pngkt.appendChild(option);
            }
        }

    </script>

    {{-- Pegawai --}}
    <script>
        var input_nip = document.querySelector(".nip_input");
        var input_username = document.querySelector(".username_input");
        var input_password = document.querySelector(".password_input");

        input_nip.addEventListener("change",function(e){
            document.querySelector(".text-info-nip-fill").innerHTML = "Username & Password akan terisi otomatis dari nip pegawai"+
                " atau anda dapat mengubahnya."
              input_username.value = e.target.value;
              input_password.value = e.target.value;
        });

    </script>

    <script>
        mapboxgl.accessToken = 'pk.eyJ1IjoiZmF0YWtodWxhZmkiLCJhIjoiY2tiZ2hwdnZhMHhoeTJ4bnlsYzNwZnVlMiJ9.MkJvbmyoVfcbgjO9yzcuoA';
        var map = new mapboxgl.Map({
            container: 'mapLokasiTempat', // container ID
            style: 'mapbox://styles/mapbox/streets-v11', // style URL
            center: [112.1833003, -7.541166], // starting position [lng, lat]
            zoom: 9 // starting zoom
        });
        map.addControl(new mapboxgl.NavigationControl());

        map.on('click', addMarker);

        var currentMarkers = [];
        if(latTempatEdit != '' && longTempatEdit != ''){
            new mapboxgl.Marker({ color: 'red' })
                .setLngLat([longTempatEdit, latTempatEdit])
                .addTo(map);
        }

        function addMarker(e){
            var marker = new mapboxgl.Marker({ color: 'green' })
                .setLngLat([e.lngLat.lng, e.lngLat.lat])
                .addTo(map);

            if(currentMarkers.length >= 1){
                currentMarkers[0].remove();
                currentMarkers[currentMarkers.length-1].remove();
            }
            currentMarkers.push(marker);
            document.querySelector(".lat_tempat").value = e.lngLat.lat;
            document.querySelector(".long_tempat").value = e.lngLat.lng;

        }

    </script>

    <script src="{{ asset("assets/plugins/ckeditor/ckeditor.js") }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.ckeditor').ckeditor();
        });
        CKEDITOR.replace('menimbang');
        var editor = CKEDITOR.instances['menimbang'];
        editor.setData("<ol type='a'><li>Bahwa dalam rangka melaksanakan tugas dan tertib administrasi Aparatur Sipil Negara diperlukan surat tugas;</li><li>Bahwa untuk memberikan kepastian hukum terhadap Aparatur Sipil Negara yang mengikuti kegiatan, instansi pengirim peserta perlu menerbitkan surat tugas;</li></ol>")
        CKEDITOR.replace('dasar');
        var editor = CKEDITOR.instances['dasar'];
        editor.setData("<ol type='a'><li>Undang-Undang No. 17 Tahun 2003 tentang keuangan Negara;</li><li>Keputusan Menteri Agama Republik Indonesia Nomor 9 Tahun 2016 tentang tata Persuratan Dinas Kementerian Agama;</li><li>KMA No. 23 Tahun 2014 tentang Pedoman Penggunaan, Pemanfaatan, Penghapusan, dan Pemindahtanganan BMN di lingkungan kementerian Agama;</li><li>KMA Nomor 607 Tahun 2020 tentang Pelimpahan Sebagian Kewenangan dan Tanggung Jawab Pengguna Barang kepada Kuasa Pengguna Barang dalam Pengelolaan BMN;</li></ol>")
        CKEDITOR.replace('perihal');
        var editor = CKEDITOR.instances['perihal'];
        editor.setData("<ol type='1'><li>Mengajukan permohonan Sewa Gedung BMN dari Bank Panin, Bank CIMB dan Bank Mega untuk Pelayanan Pendaftaran Haji periode 3 tahun</li><li>Mengajukan permohonan hibah Gedung Ex. KUA Tembelang Jombang kepada Pengurus masjid Besar Ar Rohmat Tembelang Jombang</li></ol>")
        CKEDITOR.replace('an');
        var editor = CKEDITOR.instances['an'];
        editor.setData("<h4>a.n. Kepala Kantor,<br/>Kepala Sub  Bagian Tata Usaha<br><br><br><br>Emy Chulaimi</h4>")
    </script>
</body>
</html>