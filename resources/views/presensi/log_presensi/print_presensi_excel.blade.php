<table border="1">
    <thead>
        <tr>
            <th colspan="7">Kementerian Agama Kabupaten Jombang
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
        <tr>
            <td>Jabatan</td>
            <td>{{ $pegawai->nama_jabatan }}</td>
        </tr>
        <tr></tr>
        <tr>
            <th colspan="7">Riwayat Presensi</th>
        </tr>
        <tr>
            <th colspan="7">pada tanggal {{ $tgl_awal }} sampai {{ $tgl_akhir }}</th>
        </tr>
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