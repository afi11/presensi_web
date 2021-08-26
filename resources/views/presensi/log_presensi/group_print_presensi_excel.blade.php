<table border="1">
    <thead>
        <tr>
            <th colspan="11">Kementerian Agama Kabupaten Jombang
                Jalan Pattimura 26 Telp. (0321) 861321 Faksimili (0321) 861321 Jombang 61419</th>
        </tr>
        <tr></tr>
        <tr>
            <td>NIP</td>
            <td>{{ $pegawai->nip }}</td>
        </tr>
        <tr>
            <td>NAMA</td>
            <td>{{ $pegawai->nama }}</td>
        </tr>
        <tr></tr>
        <tr>
            <th colspan="11">Riwayat Presensi</th>
        </tr>
        <tr>
            <th colspan="11">pada tanggal {{ $tgl_awal }} sampai {{ $tgl_akhir }}</th>
        </tr>
        <tr>
                <th>TL1</th>
                <th>TL2</th>
                <th>TL3</th>
                <th>TL4</th>
                <th>PSW1</th>
                <th>PSW2</th>
                <th>PSW3</th>
                <th>PSW4</th>
                <th>MASUK</th>
                <th>IZIN</th>
                <th>TIDAK PRESENSI</th>
        </tr>
    </thead>
    <tbody>
            @php
                $tl1 = countRangeStatusPresensi($pegawai->id_pegawai, $tgl_awal, $tgl_akhir,'TL-1'); 
                $tl2 = countRangeStatusPresensi($pegawai->id_pegawai, $tgl_awal, $tgl_akhir,'TL-2'); 
                $tl3 = countRangeStatusPresensi($pegawai->id_pegawai, $tgl_awal, $tgl_akhir,'TL-3'); 
                $tl4 = countRangeStatusPresensi($pegawai->id_pegawai, $tgl_awal, $tgl_akhir,'TL-4'); 
                $psw1 = countRangeStatusPresensi($pegawai->id_pegawai, $tgl_awal, $tgl_akhir,'PSW-1'); 
                $psw2 = countRangeStatusPresensi($pegawai->id_pegawai, $tgl_awal, $tgl_akhir,'PSW-2'); 
                $psw3 = countRangeStatusPresensi($pegawai->id_pegawai, $tgl_awal, $tgl_akhir,'PSW-3'); 
                $psw4 = countRangeStatusPresensi($pegawai->id_pegawai, $tgl_awal, $tgl_akhir,'PSW-4');
                $hadir = countRangeStatusPresensi($pegawai->id_pegawai, $tgl_awal, $tgl_akhir,'-');
                $izin = countRangeStatusPresensi($pegawai->id_pegawai, $tgl_awal, $tgl_akhir, null);
            @endphp
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
                    {{ countTidakHadir($pegawai->id_pegawai, $tgl_awal, $tgl_akhir, $tl1, $tl2, $tl3, $tl4, $psw1, $psw2, $psw3, $psw4, $izin,$hadir ) }}
                </td>
            </tr>
    </tbody>
</table>