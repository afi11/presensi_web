<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Pengajuan Cuti</title>
    <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
    <div class="print-pdf">
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
            <h3>Pengajuan Izin</h3>
        </div><br/>
        <div class="text_right">Jombang, {{ date_format(date_create($tgl),'d-m-Y') }}</div>
        <br />
        <p>Kepada Yth.,<br/>
        Bapak/Ibu Pimpinan<br/>
        Kementerian Agama Kabupaten Jombang<br/>
        Di tempat.</p><br/>
        <p>Dengan hormat,</p><br/>
        <p>Yang bertanda tangan di bawah ini:</p><br />
    </div>
    <table>
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
            <td>Panggkat</td>
            <td>:</td>
            <td>{{ $pegawai->pangkat }}</td>
        </tr>
        <tr>
            <td>Golongan</td>
            <td>:</td>
            <td>{{ $pegawai->golongan }}</td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>:</td>
            <td>{{ $pegawai->nama_jabatan }}</td>
        </tr>
    </table><br />
    <p>Bermaksud untuk mengajukan izin mulai tanggal {{ $presensi->tgl_start_izin }} sd {{ $presensi->tgl_end_izin }}, dikarenakan 
        {{ ($presensi->tipe_izin == 'sakit' ? 'sakit' :  'dinas_luar' ) }}. Pada Izin
    telah terlampir bukti izin.</p>
    <p>Demikian surat ini kami sampaikan, kami sampaikan terimakasih.</p><br/>
    <p>Hormat saya,</p><br/><br/>
    <p>{{ $pegawai->nama }}</p>

    @if($presensi->tipe_file == "image")
        <img class="img-bukti-izin" src="files/absensi/{{ $presensi->bukti_izin }}" />
    @endif
</body>
</html>