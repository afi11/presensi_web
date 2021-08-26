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
             {{ "" }}
        @else
             <h5>Presensi pada pada tanggal {{ $tgl_awal }} sampai {{ $tgl_akhir }}</h5>
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

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Presensi</th>
                <th>Jam Masuk</th>
                <th>Jam Pulang</th>
                <th>Status Jam Masuk</th>
                <th>Status Jam Pulang</th>
            </tr>
        </thead>
        <tbody>
            @php $no=0; @endphp
            @foreach ($presensi as $item)
            @php $no++; @endphp
            <tr>
                <td>{{ $no }}</td>
                <td>{{ $item->tgl_presensi }}</td>
                <td>
                    {{ getJamPresensi($item->pegawai_id, $item->tgl_presensi,'jam_masuk') }}
                </td>
                <td>
                    {{ getJamPresensi($item->pegawai_id, $item->tgl_presensi,'jam_pulang') }}
                </td>
                <td>
                    {{ getStatusPresensi($item->pegawai_id, $item->tgl_presensi,'jam_masuk') }}
                </td>
                <td>
                    {{ getStatusPresensi($item->pegawai_id, $item->tgl_presensi,'jam_pulang') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>