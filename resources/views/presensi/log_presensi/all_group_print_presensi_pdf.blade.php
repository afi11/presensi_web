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

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>NIP / Nama</th>
                <th>TL1</th>
                <th>TL2</th>
                <th>TL3</th>
                <th>TL4</th>
                <th>PSW1</th>
                <th>PSW2</th>
                <th>PSW3</th>
                <th>PSW4</th>
                <th>M</th>
                <th>TW</th>
                <th>I</th>
                <th>TP</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 0; @endphp
            @foreach($pegawai as $item)   @php $no++; @endphp
                @php
                    $tl1 = countRangeStatusPresensi($item->id_pegawai, ($tgl_awal == "" ? $periode->periode_awal : $tgl_awal), ($tgl_akhir == "" ? $periode->periode_akhir : $tgl_akhir),'TL-1'); 
                    $tl2 = countRangeStatusPresensi($item->id_pegawai, ($tgl_awal == "" ? $periode->periode_awal : $tgl_awal), ($tgl_akhir == "" ? $periode->periode_akhir : $tgl_akhir),'TL-2'); 
                    $tl3 = countRangeStatusPresensi($item->id_pegawai, ($tgl_awal == "" ? $periode->periode_awal : $tgl_awal), ($tgl_akhir == "" ? $periode->periode_akhir : $tgl_akhir),'TL-3'); 
                    $tl4 = countRangeStatusPresensi($item->id_pegawai, ($tgl_awal == "" ? $periode->periode_awal : $tgl_awal), ($tgl_akhir == "" ? $periode->periode_akhir : $tgl_akhir),'TL-4'); 
                    $psw1 = countRangeStatusPresensi($item->id_pegawai, ($tgl_awal == "" ? $periode->periode_awal : $tgl_awal), ($tgl_akhir == "" ? $periode->periode_akhir : $tgl_akhir),'PSW-1'); 
                    $psw2 = countRangeStatusPresensi($item->id_pegawai, ($tgl_awal == "" ? $periode->periode_awal : $tgl_awal), ($tgl_akhir == "" ? $periode->periode_akhir : $tgl_akhir),'PSW-2'); 
                    $psw3 = countRangeStatusPresensi($item->id_pegawai, ($tgl_awal == "" ? $periode->periode_awal : $tgl_awal), ($tgl_akhir == "" ? $periode->periode_akhir : $tgl_akhir),'PSW-3'); 
                    $psw4 = countRangeStatusPresensi($item->id_pegawai, ($tgl_awal == "" ? $periode->periode_awal : $tgl_awal), ($tgl_akhir == "" ? $periode->periode_akhir : $tgl_akhir),'PSW-4');
                    $tp = countRangeStatusPresensi($item->id_pegawai, ($tgl_awal == "" ? $periode->periode_awal : $tgl_awal), ($tgl_akhir == "" ? $periode->periode_akhir : $tgl_akhir),'-');
                    $hadir = countRangeStatusPresensi($item->id_pegawai, ($tgl_awal == "" ? $periode->periode_awal : $tgl_awal), ($tgl_akhir == "" ? $periode->periode_akhir : $tgl_akhir),'masuk');
                    $izin = countRangeStatusPresensi($item->id_pegawai, ($tgl_awal == "" ? $periode->periode_awal : $tgl_awal), ($tgl_akhir == "" ? $periode->periode_akhir : $tgl_akhir), null);
                @endphp
                <tr>
                    <td>{{ $no }}</td>
                    <td>{{ $item->nip }} / {{ $item->nama }}</td>
                    <td>{{ $tl1 }}</td>
                    <td>{{ $tl2 }}</td>
                    <td>{{ $tl3 }}</td>
                    <td>{{ $tl4 }}</td>
                    <td>{{ $psw1 }}</td>
                    <td>{{ $psw2 }}</td>
                    <td>{{ $psw3 }}</td>
                    <td>{{ $psw4 }}</td>
                    <td>{{ $tp }}</td>
                    <td>{{ $hadir }}</td>
                    <td>{{ $izin }}</td>
                    <td>
                        {{ countTidakHadir($item->id_pegawai, ($tgl_awal == "" ? $periode->periode_awal : $tgl_awal), ($tgl_akhir == "" ? $periode->periode_akhir : $tgl_akhir), $hadir, $izin ) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>