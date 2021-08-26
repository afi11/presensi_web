<table border="1">
    <thead>
        <tr>
            <th colspan="14">Kementerian Agama Kabupaten Jombang
                Jalan Pattimura 26 Telp. (0321) 861321 Faksimili (0321) 861321 Jombang 61419</th>
        </tr>
        <tr></tr>
        <tr>
            <th colspan="14">Data Aktifitas</th>
        </tr>
        @if($bulan != "" && $tahun != "")
        <tr>
            <th colspan="14">pada bulan {{ $bulan }} , tahun {{ $tahun }}</th>
        </tr>
        @endif
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