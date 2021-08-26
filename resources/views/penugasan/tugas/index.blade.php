@extends('templates.main')
@section('title','Halaman Penugasan')
@section('content')			
    <div class="row justify-content-center">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="mb-2">
                <ol class="breadcrumb p-0">
                  <li class="breadcrumb-item">
                    <a href="{{ url("/") }}">
                      <span class="mdi mdi-home"></span>                
                    </a>
                  </li>
                  <li class="breadcrumb-item text-success" aria-current="page">
                    Penugasan Pegawai
                  </li>
                </ol>
            </nav>
            <div class="card card-default">
                <div class="card-header card-header-border-bottom">
                    <h2>Data Penugasan Pegawai</h2>
                </div>
                <div class="card-body">
                    @if(Session::has('success'))
                        <div class="alert alert-dismissible fade show alert-success" role="alert">
                            {{ Session::get("success") }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                            <form action="{{ url('penugasan/rekap') }}" method="GET">
                                <div class="row">
                                    <div class="form-group mr-2">
                                        <label>Tahun</label>
                                        <select class="form-control years" name="tahun"></select>
                                    </div>
                                    <div class="form-group">
                                        <label>Bulan</label>
                                        <div class="input-group">
                                            <select class="form-control months" name="bulan"></select>
                                            <div class="ml-3">
                                                <button class="btn btn-primary" type="submit">Rekap</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-4">
                                <a href="{{ url('penugasan/cetak_pdf?tahun='.Request::query('tahun').'&bulan='. Request::query('bulan')) }}" class="btn btn-primary">Rekap PDF</a>
                                <a href="{{ url('penugasan/export_excel?tahun='.Request::query('tahun').'&bulan='. Request::query('bulan'))}}" class="btn btn-primary">Rekap Excel</a>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('penugasan.create') }}" class="btn btn-success btn-pill mb-3">Tambah Penugasan</a>
                    <div class="basic-data-table">
                        <table id="data" class="table nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <td>No</td>
                                    <td>Tanggal Tugas</td>
                                    <td>Dasar Pelaksanaan</td>
                                    <td>Perihal</td>
                                    <td>Status</td>
                                    <td>Aksi</td>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 0; @endphp
                                @foreach ($penugasan as $item) @php $no++; @endphp
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{ $item->tgl_berangkat}} - {{$item->tgl_kembali }}</td>
                                        <td>{{$item->no_surat}}</td>
                                        <td><?php echo $item->perihal; ?></td>
                                        <td>
                                            @if($item->status == "batal")
                                                <strong>Batal</strong>
                                            @elseif($item->status == "selesai")
                                                <strong>Selesai</strong>
                                            @elseif($item->status == "kirim")
                                                <strong>Kirim</strong>
                                            @else
                                                <strong>Proses</strong>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ url('penugasan/detail/'.$item->id) }}">
                                                <button class="btn btn-info btn-sm"><i class="icon-edit icon-white"></i>Detail</button>
                                            </a>
                                            <button type="button" data-toggle="modal" data-target="#exampleModal{{ $item->id }}" 
                                                class="btn btn-danger btn-sm">
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="exampleModal{{ $item->id }}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah Penugasan {{ $item->no_surat }} akan dihapus ?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger btn-pill" data-dismiss="modal">Tidak</button>
                                                    <form action="{{ route('penugasan.destroy', $item->no_surat) }}" method="post"> 
                                                        @csrf
                                                        @method('DELETE')    
                                                        <button type="submit" class="btn btn-primary btn-pill">Ya</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection