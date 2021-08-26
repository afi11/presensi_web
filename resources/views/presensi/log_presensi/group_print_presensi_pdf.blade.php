<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/styles.css" />
    <title>Rekap Presensi PDF</title>
</head>
<body class="print-pdf">

    <table>
        <tr>
            <td>
                <img src="logo-kemenag.png" />
            </td>
            <td>
                <h3>KEMENTERIAN AGAMA REPUBLIK INDONESIA<br/>
                KANTOR KEMENTERIAN AGAMA KABUPATEN JOMBANG</h3>
                <h5>Jalan Pattimura Nomor 26 Jombang 61416 Telepon. (0321) 861321<br/>
                Faxsimile. (0321) 861321 Email : kabjombang@kemenag.go.id</h5>
            </td>
        </tr>
    </table>

    <hr />

    <div class="text-center">
        <h2>Riwayat Presensi Pegawai</h2>
        @if($tgl_awal == "" || $tgl_akhir == "")
            <h3>Periode Presensi pada tanggal {{ $periode->periode_awal }} sampai {{ $periode->periode_akhir }}</h3>
        @else
            <h3>Periode Presensi pada tanggal {{ $tgl_awal }} sampai {{ $tgl_akhir }}</h3>
        @endif
    </div>

    <table class="det-pegawai">
        <tr>
            <td>NIP</td>
            <td>:</td>
            <td>{{ $pegawai->nip }}</td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>{{ $pegawai->nama }}</td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>:</td>
            <td>{{ $pegawai->nama_jabatan }}</td>
        </tr>
    </table>

    @php
      $tl1 = countRangeStatusPresensi($pegawai->id_pegawai, ($tgl_awal == "" ? $periode->periode_awal : $tgl_awal), ($tgl_akhir == "" ? $periode->periode_akhir : $tgl_akhir),'TL-1'); 
      $tl2 = countRangeStatusPresensi($pegawai->id_pegawai, ($tgl_awal == "" ? $periode->periode_awal : $tgl_awal), ($tgl_akhir == "" ? $periode->periode_akhir : $tgl_akhir),'TL-2'); 
      $tl3 = countRangeStatusPresensi($pegawai->id_pegawai, ($tgl_awal == "" ? $periode->periode_awal : $tgl_awal), ($tgl_akhir == "" ? $periode->periode_akhir : $tgl_akhir),'TL-3'); 
      $tl4 = countRangeStatusPresensi($pegawai->id_pegawai, ($tgl_awal == "" ? $periode->periode_awal : $tgl_awal), ($tgl_akhir == "" ? $periode->periode_akhir : $tgl_akhir),'TL-4'); 
      $psw1 = countRangeStatusPresensi($pegawai->id_pegawai, ($tgl_awal == "" ? $periode->periode_awal : $tgl_awal), ($tgl_akhir == "" ? $periode->periode_akhir : $tgl_akhir),'PSW-1'); 
      $psw2 = countRangeStatusPresensi($pegawai->id_pegawai, ($tgl_awal == "" ? $periode->periode_awal : $tgl_awal), ($tgl_akhir == "" ? $periode->periode_akhir : $tgl_akhir),'PSW-2'); 
      $psw3 = countRangeStatusPresensi($pegawai->id_pegawai, ($tgl_awal == "" ? $periode->periode_awal : $tgl_awal), ($tgl_akhir == "" ? $periode->periode_akhir : $tgl_akhir),'PSW-3'); 
      $psw4 = countRangeStatusPresensi($pegawai->id_pegawai, ($tgl_awal == "" ? $periode->periode_awal : $tgl_awal), ($tgl_akhir == "" ? $periode->periode_akhir : $tgl_akhir),'PSW-4');
      $hadir = countRangeStatusPresensi($pegawai->id_pegawai, ($tgl_awal == "" ? $periode->periode_awal : $tgl_awal), ($tgl_akhir == "" ? $periode->periode_akhir : $tgl_akhir),'-');
      $izin = countRangeStatusPresensi($pegawai->id_pegawai, ($tgl_awal == "" ? $periode->periode_awal : $tgl_awal), ($tgl_akhir == "" ? $periode->periode_akhir : $tgl_akhir), null);
    @endphp

    <table class="table">
        <thead>
            <tr>
                <th>TL1</th>
                <th>TL2</th>
                <th>TL3</th>
                <th>TL4</th>
                <th>PSW1</th>
                <th>PSW2</th>
                <th>PSW3</th>
                <th>PSW4</th>
                <th>Hadir</th>
                <th>Izin</th>
                <th>Tidak Presensi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $tl1 }}</td>
                <td>{{ $tl2 }}</td>
                <td>{{ $tl3 }}</td>
                <td>{{ $tl4 }}</td>
                <td>{{ $psw1 }}</td>
                <td>{{ $psw2 }}</td>
                <td>{{ $psw3 }}</td>
                <td>{{ $psw4 }}</td>
                <td>{{ $hadir }}</td>
                <td>{{ $izin }}</td>
                <td>
                    {{ countTidakHadir($pegawai->id_pegawai, ($tgl_awal == "" ? $periode->periode_awal : $tgl_awal), ($tgl_akhir == "" ? $periode->periode_akhir : $tgl_akhir), $tl1, $tl2, $tl3, $tl4, $psw1, $psw2, $psw3, $psw4, $izin,$hadir ) }}
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>