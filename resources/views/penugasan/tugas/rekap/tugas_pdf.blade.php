<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/styles.css" />
    <title>Rekap Penugasa PDF</title>
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
        <h2>Data Penugasan Pegawai</h2>
        @if($bulan == "" || $tahun == "")
             {{ "" }}
        @else
             <h5>Penugasan pada pada bulan {{ $bulan }} tahun {{ $tahun }}</h5>
        @endif
    </div>

    <table class="table">
        <thead>
            <tr>
                <td>No</td>
                <td>Tanggal Tugas</td>
                <td>Dasar Pelaksanaan</td>
                <td>Perihal</td>
                <td>Tempat</td>
                <td>Pegawai</td>
                <td>File</td>
            </tr>
        </thead>
        <tbody>
            @php $no=0; @endphp
            @foreach ($penugasan as $item)
            @php $no++; @endphp
            <tr>
                <td>{{ $no }}</td>
                <td>{{ $item->tgl_berangkat}} - {{$item->tgl_kembali }}</td>
                <td>{{$item->no_surat}}</td>
                <td>{{$item->perihal}}</td>
                <td>{{$item->tempat_tugas}}</td>
                <td>
                    @for($i = 0; $i < count(getNamaPegawai($item->no_surat)); $i++  )
                        {{ getNamaPegawai($item->no_surat)[$i].", " }}
                    @endfor
                </td>
                <td><a href="{{ asset('files/tugas/'.$item->file) }}">Lihat File</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>