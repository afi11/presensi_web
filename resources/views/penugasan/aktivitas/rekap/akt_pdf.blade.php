<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/styles.css" />
    <title>Rekap Aktifitas PDF</title>
</head>
<body class="print-pdf">

    <table>
        <tr>
            <td>
                <img src="logo-kemenag.png" />
            </td>
            <td>
                <h2>Kementerian Agama Kabupaten Jombang</h2>
                <h5>Jalan Pattimura 26 Telp. (0321) 861321 Faksimili (0321) 861321 Jombang 61419</h5>
            </td>
        </tr>
    </table>

    <hr />

    <div class="text-center">
        <h2>Data Aktifitas Pegawai</h2>
        @if($bulan == "" || $tahun == "")
             {{ "" }}
        @else
             <h5>Aktifitas pada pada bulan {{ $bulan }} tahun {{ $tahun }}</h5>
        @endif
    </div>

    <table class="table">
        <thead>
            <tr>
                <td>No</td>
                <td>Pegawai</td>
                <td>Uraian</td>
                <td>Satuan</td>
                <td>Kuantitas</td>
                <td>Tanggal</td>
                <td>File</td>
            </tr>
        </thead>
        <tbody>
            @php $no = 0; @endphp
            @foreach ($aktifitas as $item) @php $no++; @endphp
                <tr>
                    <td>{{ $no }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->uraian }}</td>
                    <td>{{ $item->satuan }}</td>
                    <td>{{ $item->kuantitas }}</td>
                    <td>{{ $item->tanggal }}</td>
                    <td>
                        <a target="blank" href="{{ asset('files/aktivitas/'.$item->file) }}">Lihat File</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>