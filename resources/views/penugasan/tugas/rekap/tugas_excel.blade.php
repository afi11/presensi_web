<table border="1">
    <thead>
        <tr>
            <th colspan="14">Kementerian Agama Kabupaten Jombang
                Jalan Pattimura 26 Telp. (0321) 861321 Faksimili (0321) 861321 Jombang 61419</th>
        </tr>
        <tr></tr>
        <tr>
            <th colspan="14">Data Penugasan</th>
        </tr>
        @if($bulan != "" && $tahun != "")
        <tr>
            <th colspan="14">pada bulan {{ $bulan }} , tahun {{ $tahun }}</th>
        </tr>
        @endif
        <tr>
            <td>No</td>
            <td>Tanggal Tugas</td>
            <td>Dasar Pelaksanaan</td>
            <td>Perihal</td>
            <td>Tempat</td>
            <td>Pegawai</td>
            <td>Keterangan</td>
            <td>Status</td>
            <td>File</td>
        </tr>
    </thead>
    <tbody>
        @php $no = 0; @endphp
        @foreach ($penugasan as $item) @php $no++; @endphp
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
                <td>{{$item->keterangan}}</td> 
                <td>
                    @if($item->status == "batal")
                       Batal
                    @elseif($item->status == "selesai")
                       Selesai
                    @else
                       Belum Dikerjakan
                    @endif
                </td>
                <td>
                    <a target="blank" href="{{ asset('files/absensi/'.$item->file) }}">Lihat File</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>