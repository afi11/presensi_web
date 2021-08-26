<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Tugas</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif;">
    <table>
        <tr>
            <td>
                <img src="logo-kemenag.png" width="85px" height="85px">
            </td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>
                <center>
                    <font size="3"><b>KEMENTERIAN AGAMA REPUBLIK INDONESIA</b></font><br>
                    <font size="3"><b>KANTOR KEMENTERIAN AGAMA KABUPATEN JOMBANG</b></font><br>
                    <font size="2">Jalan Pattimura Nomor 26 Jombang 61416 Telepon. (0321) 861321</font><br>
                    <font size="2">Faxsimile. (0321) 861321 Email : kabjombang@kemenag.go.id</font>
                </center>
            </td>
        </tr>
    </table>
    <hr>
    <center><b>SURAT - TUGAS</b></center>
    <center>Nomor : {{$no_surat}}</center>
    <table style="font-size: small;">
        <tr>
            <td>Menimbang</td>
            <td>:</td>
            <td><?php echo $menimbang; ?></td>
        </tr>
        <tr>
            <td>Dasar</td>
            <td>:</td>
            <td><?php echo $dasar; ?></td>
        </tr>
        <tr>
            <th colspan="3"><b>Memberi Tugas</b></th>
        </tr>
        <tr>
            <td style="vertical-align:top">Kepada</td>
            <td style="vertical-align:top">:</td>
            <td >
                <?php
                    for($i = 0; $i < count($pegawai); $i++){
                    echo 'Nama&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: '.getDataAkun($pegawai[$i])->nama.'<br/>';
                    echo 'NIP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: '.getDataAkun($pegawai[$i])->nip.'<br/>';
                    echo 'Pangkat/Gol&nbsp;&nbsp;: '.getDataAkun($pegawai[$i])->golongan.' ('.getDataAkun($pegawai[$i])->pangkat.')'.'<br/>';
                    echo 'Jabatan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: '.getDataAkun($pegawai[$i])->nama_jabatan.'<br/><br/>';  
                    }
                ?>
            </td>
        </tr>
        <tr>
            <td>Untuk</td>
            <td>:</td>
            <td ><?php echo $perihal; ?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>Pada tanggal {{$tgl_berangkat}} di {{$tempat_tugas}}.</td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td>{{$keterangan}}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: right;">Jombang, {{date("D M y")}}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: right;"><?php echo $atas_nama; ?></td>
        </tr>
        <tr>
            <td>Tembusan</td>
            <td>:</td>
            <td>{{$tembusan}}</td>
        </tr>
    </table>
</body>
</html>