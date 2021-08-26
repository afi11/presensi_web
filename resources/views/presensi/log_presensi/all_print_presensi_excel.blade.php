<table border="1">
    <thead>
        <tr>
            <th colspan="14">Kementerian Agama Kabupaten Jombang
                Jalan Pattimura 26 Telp. (0321) 861321 Faksimili (0321) 861321 Jombang 61419</th>
        </tr>
        <tr></tr>
        <tr>
            <th colspan="14">Riwayat Presensi</th>
        </tr>
        <tr>
            <th colspan="14">pada tanggal {{ $tgl_awal }} sampai {{ $tgl_akhir }}</th>
        </tr>
        <tr>
            <th>No</th>
                <th>NIP</th>
                <th>Nama</th>
                <th>TL1</th>
                <th>TL2</th>
                <th>TL3</th>
                <th>TL4</th>
                <th>PSW1</th>
                <th>PSW2</th>
                <th>PSW3</th>
                <th>PSW4</th>
                <th>TEPAT WAKTU</th>
                <th>MASUK</th>
                <th>IZIN</th>
                <th>TIDAK PRESENSI</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 0; @endphp
        @foreach($pegawai as $item)   @php $no++; @endphp
            @php
                $tl1 = countRangeStatusPresensi($item->id_pegawai, $tgl_awal, $tgl_akhir,'TL-1'); 
                $tl2 = countRangeStatusPresensi($item->id_pegawai, $tgl_awal, $tgl_akhir,'TL-2'); 
                $tl3 = countRangeStatusPresensi($item->id_pegawai, $tgl_awal, $tgl_akhir,'TL-3'); 
                $tl4 = countRangeStatusPresensi($item->id_pegawai, $tgl_awal, $tgl_akhir,'TL-4'); 
                $psw1 = countRangeStatusPresensi($item->id_pegawai, $tgl_awal, $tgl_akhir,'PSW-1'); 
                $psw2 = countRangeStatusPresensi($item->id_pegawai, $tgl_awal, $tgl_akhir,'PSW-2'); 
                $psw3 = countRangeStatusPresensi($item->id_pegawai, $tgl_awal, $tgl_akhir,'PSW-3'); 
                $psw4 = countRangeStatusPresensi($item->id_pegawai, $tgl_awal, $tgl_akhir,'PSW-4');
                $tp = countRangeStatusPresensi($item->id_pegawai, $tgl_awal, $tgl_akhir,'-');
                $hadir = countRangeStatusPresensi($item->id_pegawai, $tgl_awal, $tgl_akhir,'masuk');
                $izin = countRangeStatusPresensi($item->id_pegawai, $tgl_awal, $tgl_akhir, null);
            @endphp
            <tr>
                <td>{{ $no }}</td>
                <td>{{ $item->nip }}</td>
                <td>{{ $item->nama }}</td>
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
                    {{ countTidakHadir($item->id_pegawai, $tgl_awal, $tgl_akhir, $hadir, $izin ) }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>